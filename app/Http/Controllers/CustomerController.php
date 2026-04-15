<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Repair;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    // -----------------------------------------------
    // GET /api/customers/search?q=john
    // AJAX customer search
    // -----------------------------------------------
    public function search(Request $request): JsonResponse
    {
        $shopId = auth()->user()->active_shop_id;
        $term   = $request->input('q', '');

        $customers = Customer::where('shop_id', $shopId)
            ->when($term, function ($query) use ($term) {
                $query->where(function ($q) use ($term) {
                    $q->where('name',  'like', "%{$term}%")
                      ->orWhere('phone', 'like', "%{$term}%")
                      ->orWhere('email', 'like', "%{$term}%");
                });
            })
            ->orderBy('name')
            ->limit(8)
            ->get(['id', 'name', 'phone', 'email', 'balance']);

        return response()->json($customers);
    }

    // -----------------------------------------------
    // GET /api/customers/{id}/stats
    // Get customer stats for repair form
    // -----------------------------------------------
    public function stats(Customer $customer): JsonResponse
    {
        // Ensure customer belongs to active shop
        abort_if(
            $customer->shop_id !== auth()->user()->active_shop_id,
            403
        );

        $shopId = auth()->user()->active_shop_id;

        // Total spending across sales
        $totalSalesSpend = Sale::where('shop_id', $shopId)
            ->where('customer_id', $customer->id)
            ->where('payment_status', 'paid')
            ->sum('final_amount');

        // Total spending across repairs
        $totalRepairSpend = Repair::where('shop_id', $shopId)
            ->where('customer_id', $customer->id)
            ->sum('final_price');

        // Total repairs count
        $totalRepairs = Repair::where('shop_id', $shopId)
            ->where('customer_id', $customer->id)
            ->count();

        // Active repairs
        $activeRepairs = Repair::where('shop_id', $shopId)
            ->where('customer_id', $customer->id)
            ->whereHas('status', fn($q) => $q->where('is_completed', false))
            ->count();

        return response()->json([
            'id'                => $customer->id,
            'name'              => $customer->name,
            'phone'             => $customer->phone,
            'email'             => $customer->email,
            'address'           => $customer->address,
            'balance'           => (float) $customer->balance,
            'total_spend'       => (float) ($totalSalesSpend + $totalRepairSpend),
            'total_repairs'     => $totalRepairs,
            'active_repairs'    => $activeRepairs,
        ]);
    }

    // -----------------------------------------------
    // POST /api/customers
    // Create customer via AJAX
    // -----------------------------------------------
    public function store(Request $request): JsonResponse
    {
        $shopId = auth()->user()->active_shop_id;

        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:20'],
            'email'   => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        // Check duplicate phone in this shop
        if (!empty($validated['phone'])) {
            $exists = Customer::where('shop_id', $shopId)
                ->where('phone', $validated['phone'])
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'A customer with this phone number already exists.',
                    'errors'  => [
                        'phone' => ['Phone number already in use.']
                    ],
                ], 422);
            }
        }

        $customer = Customer::create([
            'shop_id' => $shopId,
            'name'    => $validated['name'],
            'phone'   => $validated['phone']   ?? null,
            'email'   => $validated['email']   ?? null,
            'address' => $validated['address'] ?? null,
            'balance' => 0,
        ]);

        return response()->json([
            'success'  => true,
            'message'  => "Customer {$customer->name} created successfully!",
            'customer' => [
                'id'             => $customer->id,
                'name'           => $customer->name,
                'phone'          => $customer->phone,
                'email'          => $customer->email,
                'address'        => $customer->address,
                'balance'        => 0,
                'total_spend'    => 0,
                'total_repairs'  => 0,
                'active_repairs' => 0,
            ],
        ]);
    }
}