<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    // -----------------------------------------------
    // GET /api/customers/search
    // -----------------------------------------------
    public function search(Request $request): JsonResponse
    {
        $shopId = auth()->user()->active_shop_id;
        $term   = $request->input('q', '');

        $customers = Customer::where('shop_id', $shopId)
            ->when($term, fn($q) =>
                $q->where('name',  'like', "%{$term}%")
                  ->orWhere('phone', 'like', "%{$term}%")
                  ->orWhere('email', 'like', "%{$term}%")
            )
            ->orderBy('name')
            ->limit(10)
            ->get();

        return response()->json(
            $customers->map(fn($c) => $this->_format($c))
        );
    }

    // -----------------------------------------------
    // GET /api/customers/{customer}/stats
    // -----------------------------------------------
    public function stats(Customer $customer): JsonResponse
    {
        abort_if(
            $customer->shop_id !== auth()->user()->active_shop_id,
            403
        );

        return response()->json([
            'total_spent'   => $customer->transactions()
                ->where('type', 'debit')->sum('amount'),
            'total_repairs' => $customer->repairs()->count(),
            'total_sales'   => $customer->sales()->count(),
            'balance'       => $customer->balance ?? 0,
        ]);
    }

    // -----------------------------------------------
    // POST /api/customers
    // -----------------------------------------------
    public function store(Request $request): JsonResponse
    {
        $shopId = auth()->user()->active_shop_id;

        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:100'],
            'phone'   => ['nullable', 'string', 'max:20'],
            'email'   => ['nullable', 'email', 'max:100'],
            'address' => ['nullable', 'string', 'max:255'],
            'notes'   => ['nullable', 'string', 'max:1000'],
        ]);

        $customer = Customer::create([
            'shop_id' => $shopId,
            ...$validated,
        ]);

        return response()->json([
            'success'  => true,
            'message'  => "Customer \"{$customer->name}\" created!",
            'customer' => $this->_format($customer),
        ]);
    }

    // -----------------------------------------------
    // PUT /api/customers/{customer}
    // -----------------------------------------------
    public function update(Request $request, Customer $customer): JsonResponse
    {
        abort_if(
            $customer->shop_id !== auth()->user()->active_shop_id,
            403
        );

        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:100'],
            'phone'   => ['nullable', 'string', 'max:20'],
            'email'   => ['nullable', 'email', 'max:100'],
            'address' => ['nullable', 'string', 'max:255'],
            'notes'   => ['nullable', 'string', 'max:1000'],
        ]);

        $customer->update($validated);

        return response()->json([
            'success'  => true,
            'message'  => "Customer \"{$customer->name}\" updated!",
            'customer' => $this->_format($customer),
        ]);
    }

    // -----------------------------------------------
    // Format customer for JSON
    // -----------------------------------------------
    private function _format(Customer $customer): array
    {
        return [
            'id'      => $customer->id,
            'name'    => $customer->name,
            'phone'   => $customer->phone,
            'email'   => $customer->email,
            'address' => $customer->address,
            'notes'   => $customer->notes,
        ];
    }
}