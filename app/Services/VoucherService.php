<?php

namespace App\Services;

use App\Models\Voucher;
use App\Models\Shop;

class VoucherService
{
    // -----------------------------------------------
    // Validate voucher by code
    // Returns array with valid + discount info
    // -----------------------------------------------
    public function validate(
        string $code,
        int    $shopId,
        float  $total,
        ?int   $customerId = null
    ): array {
        // Find voucher
        $voucher = Voucher::forShop($shopId)
            ->where('code', strtoupper(trim($code)))
            ->first();

        if (!$voucher) {
            return [
                'valid'    => false,
                'message'  => 'Voucher code not found.',
                'voucher'  => null,
                'discount' => 0,
            ];
        }

        // Check if can be used
        $check = $voucher->canBeUsed($customerId, $total);

        if (!$check['valid']) {
            return [
                'valid'    => false,
                'message'  => $check['message'],
                'voucher'  => null,
                'discount' => 0,
            ];
        }

        // Calculate discount
        $discount = $voucher->calculateDiscount($total);

        return [
            'valid'       => true,
            'message'     => "Voucher applied! {$voucher->formatted_value} off.",
            'voucher'     => [
                'id'          => $voucher->id,
                'code'        => $voucher->code,
                'type'        => $voucher->type,
                'value'       => (float) $voucher->value,
                'formatted'   => $voucher->formatted_value,
            ],
            'discount'    => $discount,
            'new_total'   => max(0, $total - $discount),
        ];
    }

    // -----------------------------------------------
    // Redeem voucher — increment used_count
    // Called after successful sale/repair
    // -----------------------------------------------
    public function redeem(int $voucherId): void
    {
        $voucher = Voucher::find($voucherId);
        if ($voucher) {
            $voucher->redeem();
        }
    }

    // -----------------------------------------------
    // Redeem by code
    // -----------------------------------------------
    public function redeemByCode(string $code, int $shopId): void
    {
        $voucher = Voucher::forShop($shopId)
            ->where('code', strtoupper(trim($code)))
            ->first();

        if ($voucher) {
            $voucher->redeem();
        }
    }

    // -----------------------------------------------
    // Generate unique voucher code
    // -----------------------------------------------
    public function generateCode(int $shopId, int $length = 8): string
    {
        do {
            $code = strtoupper(substr(
                str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'),
                0,
                $length
            ));
        } while (
            Voucher::forShop($shopId)
                ->where('code', $code)
                ->exists()
        );

        return $code;
    }

    // -----------------------------------------------
    // Get vouchers summary for shop
    // -----------------------------------------------
    public function getSummary(int $shopId): array
    {
        $total    = Voucher::forShop($shopId)->count();
        $active   = Voucher::forShop($shopId)->valid()->count();
        $expired  = Voucher::forShop($shopId)
            ->where('expiry_date', '<', now()->toDateString())
            ->count();
        $usedUp   = Voucher::forShop($shopId)
            ->whereNotNull('usage_limit')
            ->whereColumn('used_count', '>=', 'usage_limit')
            ->count();

        return compact('total', 'active', 'expired', 'usedUp');
    }
}