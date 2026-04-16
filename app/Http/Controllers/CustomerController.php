<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    // -----------------------------------------------
    // GET /customers
    // -----------------------------------------------
    public function index(Request $request)
    {
        $shopId  = auth()->user()->active_shop_id;
        $search  = trim((string) $request->input('search', ''));

        $customers = Customer::forShop($shopId)
            ->withCount(['repairs', 'sales'])
            ->withSum('repairs', 'final_price')
            ->withSum('sales', 'final_amount')
            ->when($search !== '', fn($query) => $query->search($search))
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('customers.index', compact('customers', 'search'));
    }

    // -----------------------------------------------
    // GET /customers/{customer}
    // -----------------------------------------------
    public function show(Customer $customer)
    {
        abort_if($customer->shop_id !== auth()->user()->active_shop_id, 403);

        $customer->load([
            'repairs' => fn($query) => $query
                ->latest()
                ->limit(20)
                ->with(['status:id,name,color']),
            'sales' => fn($query) => $query->latest()->limit(20),
        ]);

        $summary = [
            'total_repairs'       => $customer->repairs()->count(),
            'total_repair_value'  => (float) $customer->repairs()->sum('final_price'),
            'total_sales'         => $customer->sales()->count(),
            'total_sales_value'   => (float) $customer->sales()->sum('final_amount'),
            'total_spent'         => (float) ($customer->repairs()->sum('final_price') + $customer->sales()->sum('final_amount')),
        ];

        return view('customers.show', compact('customer', 'summary'));
    }

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