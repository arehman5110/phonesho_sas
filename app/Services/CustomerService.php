<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\CustomerTransaction;
use Illuminate\Support\Facades\DB;

class CustomerService
{
    // -----------------------------------------------
    // Add a debit transaction (customer owes more)
    // -----------------------------------------------
    public function debit(
        Customer $customer,
        float $amount,
        string $note = null,
        string $referenceType = null,
        int $referenceId = null
    ): CustomerTransaction {
        return $this->createTransaction(
            $customer,
            'debit',
            $amount,
            $note,
            $referenceType,
            $referenceId
        );
    }

    // -----------------------------------------------
    // Add a credit transaction (customer pays)
    // -----------------------------------------------
    public function credit(
        Customer $customer,
        float $amount,
        string $note = null,
        string $referenceType = null,
        int $referenceId = null
    ): CustomerTransaction {
        return $this->createTransaction(
            $customer,
            'credit',
            $amount,
            $note,
            $referenceType,
            $referenceId
        );
    }

    // -----------------------------------------------
    // Core transaction creator
    // -----------------------------------------------
    private function createTransaction(
        Customer $customer,
        string $type,
        float $amount,
        string $note = null,
        string $referenceType = null,
        int $referenceId = null
    ): CustomerTransaction {
        return DB::transaction(function () use (
            $customer, $type, $amount,
            $note, $referenceType, $referenceId
        ) {
            // Create transaction record
            $transaction = CustomerTransaction::create([
                'shop_id'        => $customer->shop_id,
                'customer_id'    => $customer->id,
                'user_id'        => auth()->id(),
                'type'           => $type,
                'amount'         => $amount,
                'reference_type' => $referenceType,
                'reference_id'   => $referenceId,
                'note'           => $note,
            ]);

            // Update customer balance
            // debit  = balance goes UP   (owes more)
            // credit = balance goes DOWN (owes less)
            if ($type === 'debit') {
                $customer->increment('balance', $amount);
            } else {
                $customer->decrement('balance', $amount);
            }

            return $transaction;
        });
    }

    // -----------------------------------------------
    // Get customer summary
    // -----------------------------------------------
    public function getSummary(Customer $customer): array
    {
        $transactions = $customer->transactions();

        return [
            'total_debit'  => $transactions->clone()->debits()->sum('amount'),
            'total_credit' => $transactions->clone()->credits()->sum('amount'),
            'balance'      => $customer->balance,
            'status'       => $customer->balance_status,
        ];
    }
}