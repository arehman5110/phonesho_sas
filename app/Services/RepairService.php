<?php

namespace App\Services;

use App\Models\Repair;
use App\Models\RepairDevice;
use App\Models\RepairPart;
use App\Models\Payment;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\RepairType;

class RepairService
{
    public function __construct(protected StockService $stockService, protected CustomerService $customerService) {}

    // -----------------------------------------------
    // Create full repair with devices, parts, payments
    // -----------------------------------------------
    public function createRepair(array $data): Repair
    {
        return DB::transaction(function () use ($data) {
            // ── Step 1: Calculate totals ──────────────
            $totalPrice = collect($data['devices'] ?? [])->sum(fn($d) => (float) ($d['price'] ?? 0));

            $discount = (float) ($data['discount'] ?? 0);
            $finalPrice = max(0, $totalPrice - $discount);

            // ── Step 2: Create repair record ──────────
            $repair = Repair::create([
                'shop_id' => $data['shop_id'],
                'parent_repair_id' => $data['parent_repair_id'] ?? null, // ← add
                'is_warranty_return' => $data['is_warranty_return'] ?? false, // ← add
                'customer_id' => $data['customer_id'] ?? null,
                'status_id' => $data['status_id'],
                'created_by' => auth()->id(),
                'assigned_to' => $data['assigned_to'] ?? null,
                'total_price' => $totalPrice,
                'discount' => $discount,
                'final_price' => $finalPrice,
                'book_in_date' => $data['book_in_date'] ?? today(),
                'completion_date' => $data['completion_date'] ?? null,
                'delivery_type' => $data['delivery_type'],
                'notes' => $data['notes'] ?? null,
            ]);

            // ── Step 3: Create devices + parts ────────
            foreach ($data['devices'] ?? [] as $deviceData) {
                $this->_createDevice($repair, $deviceData, $data['status_id']);
            }

            // ── Step 4: Save payments ─────────────────
            if (!empty($data['payments'])) {
                $this->_savePayments($repair, $data['payments']);
            }

            // ── Step 5: Update customer balance ───────
            if (!empty($repair->customer_id)) {
                $this->_updateCustomerBalance($repair);
            }

            return $repair->load(['devices.parts', 'payments', 'customer', 'status']);
        });
    }

    // -----------------------------------------------
    // Create a single repair device + its parts
    // -----------------------------------------------
    private function _createDevice(Repair $repair, array $deviceData, int $statusId): RepairDevice
    {
        $issueString = collect($deviceData['issues'] ?? [])
            ->map(fn($i) => $i['label'] ?? $i)
            ->filter()
            ->implode(', ');

        // Resolve status — use device's own status or repair status
        $deviceStatusId = !empty($deviceData['status_id']) ? $deviceData['status_id'] : $statusId;

        // Resolve warranty expiry
        $warrantyDays = !empty($deviceData['warranty_days']) ? (int) $deviceData['warranty_days'] : null;

        $warrantyExpiry = $warrantyDays ? now()->addDays($warrantyDays)->toDateString() : null;

        $device = $repair->devices()->create([
            'device_name' => $deviceData['device_name'],
            'device_type_id' => $deviceData['device_type_id'] ?? null,
            'status_id' => $deviceStatusId,
            'imei' => $deviceData['imei'] ?? null,
            'color' => $deviceData['color'] ?? null,
            'issue' => $issueString ?: null,
            // Join multiple repair types into comma-separated string
'repair_type' => !empty($deviceData['repair_types'])
    ? implode(', ', array_filter($deviceData['repair_types']))
    : ($deviceData['repair_type'] ?? null),
            'notes' => $deviceData['notes'] ?? null,
            'warranty_status' => $deviceData['warranty_status'] ?? 'none',
            'warranty_days' => $warrantyDays,
            'warranty_expiry_date' => $warrantyExpiry,
            'price' => (float) ($deviceData['price'] ?? 0),
        ]);

        // If repair type text — save to repair_types table
        // Save each repair type to repair_types table
$typesToSave = !empty($deviceData['repair_types'])
    ? array_filter($deviceData['repair_types'])
    : (
        !empty($deviceData['repair_type'])
            ? [$deviceData['repair_type']]
            : []
      );

foreach ($typesToSave as $typeName) {
    if (!trim($typeName)) continue;
    $rt = RepairType::findOrCreateForShop($repair->shop_id, trim($typeName));
    $rt->incrementUsage();
}

        // Create parts
        foreach ($deviceData['parts'] ?? [] as $partData) {
            if (empty($partData['name'])) {
                continue;
            }
            $this->_createPart($device, $partData, $repair);
        }

        return $device;
    }

    // -----------------------------------------------
    // Create repair part + handle stock
    // -----------------------------------------------
    private function _createPart(RepairDevice $device, array $partData, Repair $repair): RepairPart
    {
        $productId = !empty($partData['product_id']) ? (int) $partData['product_id'] : null;

        $quantity = (int) ($partData['quantity'] ?? 1);

        // Create part record
        $part = $device->parts()->create([
            'product_id' => $productId,
            'user_id' => auth()->id(),
            'name' => $partData['name'],
            'quantity' => $quantity,
            'price' => 0,
            'stock_deducted' => false,
            'notes' => $partData['note'] ?? null,
        ]);

        // If linked to inventory product — reduce stock
        if ($productId) {
            $product = \App\Models\Product::find($productId);

            if ($product) {
                try {
                    $this->stockService->removeStock(product: $product, quantity: $quantity, type: 'repair', note: "Used in repair {$repair->reference}", referenceType: Repair::class, referenceId: $repair->id);

                    // Mark stock as deducted
                    $part->update(['stock_deducted' => true]);
                } catch (\Exception $e) {
                    Log::warning("Stock deduction failed for product {$productId}: " . $e->getMessage());
                }
            }
        }

        return $part;
    }

    // -----------------------------------------------
    // Save payment records
    // -----------------------------------------------
    private function _savePayments(Repair $repair, array $payments): void
    {
        foreach ($payments as $paymentData) {
            $amount = (float) ($paymentData['amount'] ?? 0);
            if ($amount <= 0) {
                continue;
            }

            Payment::create([
                'shop_id' => $repair->shop_id,
                'user_id' => auth()->id(),
                'payable_type' => Repair::class,
                'payable_id' => $repair->id,
                'method' => $paymentData['method'] ?? 'cash',
                'amount' => $amount,
                'split_part' => $paymentData['split_part'] ?? null,
                'reference' => $repair->reference,
                'note' => $paymentData['note'] ?? null,
            ]);
        }

        // Update payment status on repair
        $this->_updateRepairPaymentStatus($repair);
    }

    // -----------------------------------------------
    // Determine and update payment status
    // -----------------------------------------------
    private function _updateRepairPaymentStatus(Repair $repair): void
    {
        $totalPaid = (float) $repair->payments()->sum('amount');
        $finalPrice = (float) $repair->final_price;

        // No price set — mark as pending
        if ($finalPrice <= 0) {
            return;
        }

        $status = match (true) {
            $totalPaid <= 0 => 'pending',
            $totalPaid >= $finalPrice => 'paid',
            default => 'partial',
        };

        // Store payment status in notes for now
        // Will be added as column in next migration if needed
        Log::info("Repair {$repair->reference} payment status: {$status}");
    }

    // -----------------------------------------------
    // Update customer outstanding balance
    // -----------------------------------------------
    private function _updateCustomerBalance(Repair $repair): void
    {
        $totalPaid = (float) $repair->payments()->sum('amount');
        $finalPrice = (float) $repair->final_price;
        $outstanding = max(0, $finalPrice - $totalPaid);

        if ($outstanding <= 0) {
            return;
        }

        try {
            $customer = Customer::find($repair->customer_id);
            if (!$customer) {
                return;
            }

            $this->customerService->debit(customer: $customer, amount: $outstanding, note: "Repair {$repair->reference} — outstanding", referenceType: Repair::class, referenceId: $repair->id);
        } catch (\Exception $e) {
            Log::warning('Customer balance update failed: ' . $e->getMessage());
        }
    }

    // -----------------------------------------------
    // Get repair summary
    // -----------------------------------------------
    public function getSummary(Repair $repair): array
    {
        $totalPaid = (float) $repair->payments()->sum('amount');
        $finalPrice = (float) $repair->final_price;
        $outstanding = max(0, $finalPrice - $totalPaid);

        return [
            'total_price' => $finalPrice,
            'total_paid' => $totalPaid,
            'outstanding' => $outstanding,
            'is_paid' => $outstanding <= 0,
            'devices_count' => $repair->devices()->count(),
            'parts_count' => $repair->devices()->withCount('parts')->get()->sum('parts_count'),
        ];
    }
}
