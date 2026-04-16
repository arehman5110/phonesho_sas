<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class SaleService
{
    public function __construct(protected StockService $stockService, protected CustomerService $customerService, protected PaymentService $paymentService) {}

    // -----------------------------------------------
    // Create a complete sale with items + payments
    // -----------------------------------------------
    public function createSale(array $data, array $items): Sale
    {
        return DB::transaction(function () use ($data, $items) {
            // ── Step 1: Calculate totals ─────────────────────
            $totalAmount = collect($items)->sum(fn($item) => $item['quantity'] * $item['price']);
            $discount = (float) ($data['discount'] ?? 0);
            $finalAmount = max(0, $totalAmount - $discount);

            // ── Step 2: Determine payment status ─────────────
            $paymentStatus = $this->_resolvePaymentStatus($data, $finalAmount);

            // ── Step 3: Create sale record ────────────────────
            $sale = Sale::create([
                'shop_id' => $data['shop_id'],
                'customer_id' => $data['customer_id'] ?? null,
                'created_by' => auth()->id(),
                'total_amount' => $totalAmount,
                'discount' => $discount,
                'final_amount' => $finalAmount,
                'payment_status' => $paymentStatus,
                'payment_method' => $this->_resolvePaymentMethod($data),
                'notes' => $data['notes'] ?? null,
            ]);

            // ── Step 4: Create sale items + reduce stock ──────
            foreach ($items as $item) {
                $this->_processSaleItem($sale, $item);
            }

            // ── Step 5: Handle custom items (no stock) ────────
            if (!empty($data['custom_items'])) {
                foreach ($data['custom_items'] as $custom) {
                    $sale->items()->create([
                        'product_id' => null,
                        'product_name' => $custom['name'],
                        'quantity' => $custom['quantity'] ?? 1,
                        'price' => $custom['price'],
                        'cost_price' => 0,
                        'line_total' => ($custom['quantity'] ?? 1) * $custom['price'],
                    ]);
                }
            }

            // ── Step 6: Record payments ───────────────────────
            $this->paymentService->recordSalePayments($sale, $this->_buildPaymentData($data, $finalAmount));

            // ── Step 7: Update customer balance if needed ─────
            if (!empty($sale->customer_id) && $sale->payment_status !== 'paid') {
                $outstanding = (float) $finalAmount - (float) $sale->payments()->sum('amount');

                if ($outstanding > 0) {
                    $customer = Customer::findOrFail($sale->customer_id);
                    $this->customerService->debit(customer: $customer, amount: $outstanding, note: "Sale {$sale->reference} — outstanding", referenceType: Sale::class, referenceId: $sale->id);
                }
            }

            // ── Step 8: Auto-send receipt email if customer has email ──
            if (!empty($sale->customer_id)) {
                $customer = \App\Models\Customer::find($sale->customer_id);
                if ($customer?->email) {
                    try {
                        \Illuminate\Support\Facades\Mail::to($customer->email)->queue(new \App\Mail\ReceiptMail($sale, null, null));
                    } catch (\Exception $e) {
                        // Don't fail the sale if email fails
                        \Illuminate\Support\Facades\Log::warning('Receipt email failed: ' . $e->getMessage());
                    }
                }
            }

            return $sale->load(['items', 'payments']);
        });
    }

    // -----------------------------------------------
    // Process a single sale item
    // -----------------------------------------------
    private function _processSaleItem(Sale $sale, array $item): void
    {
        $product = Product::findOrFail($item['product_id']);

        // Create sale item
        $sale->items()->create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => $item['quantity'],
            'price' => $item['price'],
            'cost_price' => $product->cost_price,
            'line_total' => $item['quantity'] * $item['price'],
        ]);

        // Reduce stock — allow negative for out of stock items
        $this->stockService->removeStock(product: $product, quantity: $item['quantity'], type: 'sale', note: "Sale {$sale->reference}", referenceType: Sale::class, referenceId: $sale->id);
    }

    // -----------------------------------------------
    // Build payment data from request
    // -----------------------------------------------
    private function _buildPaymentData(array $data, float $finalAmount): array
    {
        $method = $data['payment_method'] ?? 'cash';

        // ── Split payment ─────────────────────────────
        if ($method === 'split') {
            $splits = [];

            $amount1 = (float) ($data['split_cash'] ?? 0);
            $amount2 = (float) ($data['split_card'] ?? 0);

            // 1st payment — use whatever method was selected
            if ($amount1 > 0) {
                $splits[] = [
                    'method' => $data['split1_method'] ?? 'cash',
                    'amount' => $amount1,
                    'note' => $data['split1_note'] ?? null,
                ];
            }

            // 2nd payment — use whatever method was selected
            if ($amount2 > 0) {
                $splits[] = [
                    'method' => $data['split2_method'] ?? 'card',
                    'amount' => $amount2,
                    'note' => $data['split2_note'] ?? null,
                ];
            }

            return [
                'method' => 'split',
                'splits' => $splits,
            ];
        }

        // ── Trade-in payment ──────────────────────────
        if ($method === 'trade') {
            return [
                'method' => 'trade',
                'trade_value' => (float) ($data['trade_value'] ?? 0),
            ];
        }

        // ── Single payment — cash / card / other ──────
        return [
            'method' => $method,
            'amount' => $finalAmount,
            'note' => $data['notes'] ?? null,
        ];
    }

    // -----------------------------------------------
    // Resolve payment status from request data
    // -----------------------------------------------
    private function _resolvePaymentStatus(array $data, float $finalAmount): string
    {
        $method = $data['payment_method'] ?? 'cash';

        // Trade — check if trade value covers full amount
        if ($method === 'trade') {
            $tradeValue = (float) ($data['trade_value'] ?? 0);
            if ($tradeValue >= $finalAmount) {
                return 'paid';
            }
            if ($tradeValue > 0) {
                return 'partial';
            }
            return 'pending';
        }

        // Split — check if total split covers full amount
        if ($method === 'split') {
            $splitTotal = (float) ($data['split_cash'] ?? 0) + (float) ($data['split_card'] ?? 0);

            if ($splitTotal >= $finalAmount) {
                return 'paid';
            }
            if ($splitTotal > 0) {
                return 'partial';
            }
            return 'pending';
        }

        // Cash / card — treat as fully paid
        return 'paid';
    }

    // -----------------------------------------------
    // Resolve display payment method
    // -----------------------------------------------
    private function _resolvePaymentMethod(array $data): string
    {
        return match ($data['payment_method'] ?? 'cash') {
            'split' => 'split',
            'trade' => 'other',
            default => $data['payment_method'] ?? 'cash',
        };
    }

    // -----------------------------------------------
    // Get daily summary for a shop
    // -----------------------------------------------
    public function getDailySummary(int $shopId): array
    {
        $sales = Sale::forShop($shopId)->today();

        return [
            'total_sales' => $sales->clone()->count(),
            'total_revenue' => $sales->clone()->sum('final_amount'),
            'total_discount' => $sales->clone()->sum('discount'),
            'paid' => $sales->clone()->paid()->count(),
            'pending' => $sales->clone()->pending()->count(),
            'partial' => $sales->clone()->partial()->count(),
        ];
    }
}