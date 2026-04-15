<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    // -----------------------------------------------
    // Record payments for a sale
    // Called from SaleService after sale is created
    // -----------------------------------------------
    public function recordSalePayments(Sale $sale, array $paymentData): void
    {
        DB::transaction(function () use ($sale, $paymentData) {
            $method = $paymentData['method'] ?? 'cash';

            match ($method) {
                'split' => $this->_recordSplitPayments($sale, $paymentData),
                'trade' => $this->_recordTradePayment($sale, $paymentData),
                default => $this->_recordSinglePayment($sale, $paymentData),
            };

            // Update sale payment status based on total paid
            $this->_updateSalePaymentStatus($sale);
        });
    }

    // -----------------------------------------------
    // Single payment — cash / card / other
    // -----------------------------------------------
    private function _recordSinglePayment(Sale $sale, array $data): void
    {
        $amount = $data['amount'] ?? $sale->final_amount;

        Payment::create([
            'shop_id' => $sale->shop_id,
            'user_id' => auth()->id(),
            'payable_type' => Sale::class,
            'payable_id' => $sale->id,
            'method' => $data['method'] ?? 'cash',
            'amount' => min((float) $amount, (float) $sale->final_amount),
            'reference' => $sale->reference,
            'note' => $data['note'] ?? null,
        ]);
    }

    // -----------------------------------------------
    // Split payment — two payments with different methods
    // -----------------------------------------------
    private function _recordSplitPayments(Sale $sale, array $data): void
    {
        $splits = $data['splits'] ?? [];

        foreach ($splits as $split) {
            $amount = (float) ($split['amount'] ?? 0);
            if ($amount <= 0) {
                continue;
            }

            // Map split method to valid payment method
            $method = in_array($split['method'], ['cash', 'card', 'trade', 'other']) ? $split['method'] : 'cash';

            Payment::create([
                'shop_id' => $sale->shop_id,
                'user_id' => auth()->id(),
                'payable_type' => Sale::class,
                'payable_id' => $sale->id,
                'method' => 'split',
                'amount' => $amount,
                'split_part' => $method,
                'reference' => $sale->reference,
                'note' => $split['note'] ?? null,
            ]);
        }
    }

    // -----------------------------------------------
    // Trade-in payment
    // -----------------------------------------------
    private function _recordTradePayment(Sale $sale, array $data): void
    {
        $tradeValue = (float) ($data['trade_value'] ?? 0);
        $remaining = (float) $sale->final_amount - $tradeValue;

        // Trade-in portion
        Payment::create([
            'shop_id' => $sale->shop_id,
            'user_id' => auth()->id(),
            'payable_type' => Sale::class,
            'payable_id' => $sale->id,
            'method' => 'trade',
            'amount' => min($tradeValue, (float) $sale->final_amount),
            'split_part' => null,
            'reference' => $sale->reference,
            'note' => $data['trade_device'] ? "Trade-in: {$data['trade_device']}" : 'Trade-in payment',
        ]);

        // If trade value covers full amount — done
        if ($remaining <= 0) {
            return;
        }

        // Otherwise record remaining as cash
        Payment::create([
            'shop_id' => $sale->shop_id,
            'user_id' => auth()->id(),
            'payable_type' => Sale::class,
            'payable_id' => $sale->id,
            'method' => 'cash',
            'amount' => $remaining,
            'split_part' => null,
            'reference' => $sale->reference,
            'note' => 'Remaining after trade-in',
        ]);
    }

    // -----------------------------------------------
    // Update sale payment_status based on total paid
    // -----------------------------------------------
    private function _updateSalePaymentStatus(Sale $sale): void
    {
        $totalPaid = (float) $sale->payments()->sum('amount');
        $finalAmount = (float) $sale->final_amount;

        $status = match (true) {
            $totalPaid <= 0 => 'pending',
            $totalPaid >= $finalAmount => 'paid',
            default => 'partial',
        };

        $sale->update(['payment_status' => $status]);
    }

    // -----------------------------------------------
    // Add a payment to an existing sale
    // (used when customer pays outstanding balance)
    // -----------------------------------------------
    public function addPaymentToSale(Sale $sale, float $amount, string $method = 'cash', string $note = null): Payment
    {
        return DB::transaction(function () use ($sale, $amount, $method, $note) {
            // Cap at outstanding balance
            $outstanding = (float) $sale->final_amount - (float) $sale->payments()->sum('amount');

            $amount = min($amount, $outstanding);

            if ($amount <= 0) {
                throw new \Exception('No outstanding balance on this sale.');
            }

            $payment = Payment::create([
                'shop_id' => $sale->shop_id,
                'user_id' => auth()->id(),
                'payable_type' => Sale::class,
                'payable_id' => $sale->id,
                'method' => $method,
                'amount' => $amount,
                'reference' => $sale->reference,
                'note' => $note,
            ]);

            $this->_updateSalePaymentStatus($sale);

            return $payment;
        });
    }

    // -----------------------------------------------
    // Get payment summary for a sale
    // -----------------------------------------------
    public function getSaleSummary(Sale $sale): array
    {
        $payments = $sale->payments()->get();
        $totalPaid = $payments->sum('amount');
        $outstanding = max(0, (float) $sale->final_amount - $totalPaid);

        return [
            'total_amount' => (float) $sale->final_amount,
            'total_paid' => (float) $totalPaid,
            'outstanding' => (float) $outstanding,
            'is_paid' => $outstanding <= 0,
            'status' => $sale->payment_status,
            'payments' => $payments
                ->map(
                    fn($p) => [
                        'id' => $p->id,
                        'method' => $p->method,
                        'split_part' => $p->split_part,
                        'amount' => (float) $p->amount,
                        'note' => $p->note,
                        'created_at' => $p->created_at->format('d/m/Y H:i'),
                    ],
                )
                ->toArray(),
        ];
    }
}
