<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\Customer;
use App\Services\VoucherService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class VoucherController extends Controller
{
    public function __construct(
        protected VoucherService $voucherService,
    ) {}

    // -----------------------------------------------
    // GET /vouchers
    // -----------------------------------------------
    public function index(Request $request)
    {
        $shopId = auth()->user()->active_shop_id;

        $query = Voucher::forShop($shopId)
            ->with('assignedCustomer')
            ->latest();

        // Search
        if ($request->filled('search')) {
            $query->where('code', 'like', "%{$request->search}%")
                  ->orWhere('notes', 'like', "%{$request->search}%");
        }

        // Status filter
        if ($request->filled('status')) {
            match($request->status) {
                'active'  => $query->valid(),
                'expired' => $query->where(
                    'expiry_date', '<', now()->toDateString()
                ),
                'inactive' => $query->where('is_active', false),
                default   => null,
            };
        }

        $vouchers = $query->paginate(20)->withQueryString();
        $s        = $this->voucherService->getSummary($shopId);
        $summary  = array_merge($s, [
            'used'     => $s['usedUp'] ?? 0,
            'inactive' => max(0, ($s['total'] ?? 0) - ($s['active'] ?? 0) - ($s['expired'] ?? 0) - ($s['usedUp'] ?? 0)),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'html'    => view('vouchers.partials.list', compact('vouchers', 'summary'))->render(),
                'summary' => $summary,
            ]);
        }

        $customers     = Customer::where('shop_id', $shopId)->orderBy('name')->get(['id','name','phone']);
        $suggestedCode = $this->voucherService->generateCode($shopId);

        return view('vouchers.index', compact('vouchers', 'summary', 'customers', 'suggestedCode'));
    }

    // -----------------------------------------------
    // GET /vouchers/create
    // -----------------------------------------------
    public function create()
    {
        $shopId    = auth()->user()->active_shop_id;
        $customers = Customer::where('shop_id', $shopId)
            ->orderBy('name')
            ->get(['id', 'name', 'phone']);

        $suggestedCode = $this->voucherService->generateCode($shopId);

        return view('vouchers.create', compact(
            'customers',
            'suggestedCode'
        ));
    }

    // -----------------------------------------------
    // POST /vouchers
    // -----------------------------------------------
    public function store(Request $request)
    {
        $shopId = auth()->user()->active_shop_id;

        $validated = $request->validate([
            'code'             => [
                'required',
                'string',
                'max:50',
                'alpha_num',
                \Illuminate\Validation\Rule::unique('vouchers')
                    ->where('shop_id', $shopId),
            ],
            'type'             => ['required', 'in:fixed,percentage'],
            'value'            => ['required', 'numeric', 'min:0.01'],
            'usage_limit'      => ['nullable', 'integer', 'min:1'],
            'min_order_amount' => ['nullable', 'numeric', 'min:0'],
            'assigned_to'      => ['nullable', 'exists:customers,id'],
            'expiry_date'      => ['nullable', 'date', 'after:today'],
            'is_active'        => ['nullable', 'boolean'],
            'notes'            => ['nullable', 'string', 'max:500'],
        ]);

        $validated['code']             = strtoupper($validated['code']);
$validated['shop_id']          = $shopId;
$validated['is_active']        = $request->boolean('is_active', true);
$validated['min_order_amount'] = $validated['min_order_amount'] ?? 0;
$validated['usage_limit']      = $validated['usage_limit']      ?? null;
$validated['assigned_to']      = $validated['assigned_to']      ?? null;
$validated['expiry_date']      = $validated['expiry_date']      ?? null;
$validated['notes']            = $validated['notes']            ?? null;

        // Percentage max 100
        if ($validated['type'] === 'percentage' && $validated['value'] > 100) {
            return back()->withInput()
                ->withErrors(['value' => 'Percentage cannot exceed 100%.']);
        }

        $voucher = Voucher::create($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Voucher {$voucher->code} created!",
                'voucher' => $this->_formatVoucher($voucher->load('assignedCustomer')),
                'new_code'=> $this->voucherService->generateCode($shopId),
            ]);
        }

        return redirect()->route('vouchers.index')->with('success', "Voucher {$voucher->code} created!");
    }

    // -----------------------------------------------
    // GET /vouchers/{voucher}/edit
    // -----------------------------------------------
    public function edit(Voucher $voucher)
    {
        abort_if(
            $voucher->shop_id !== auth()->user()->active_shop_id,
            403
        );

        $shopId    = auth()->user()->active_shop_id;
        $customers = Customer::where('shop_id', $shopId)
            ->orderBy('name')
            ->get(['id', 'name', 'phone']);

        return view('vouchers.edit', compact('voucher', 'customers'));
    }

    // -----------------------------------------------
    // PUT /vouchers/{voucher}
    // -----------------------------------------------
    public function update(Request $request, Voucher $voucher)
    {
        abort_if(
            $voucher->shop_id !== auth()->user()->active_shop_id,
            403
        );

        $shopId = auth()->user()->active_shop_id;

        $validated = $request->validate([
            'code'             => [
                'required',
                'string',
                'max:50',
                'alpha_num',
                \Illuminate\Validation\Rule::unique('vouchers')
                    ->where('shop_id', $shopId)
                    ->ignore($voucher->id),
            ],
            'type'             => ['required', 'in:fixed,percentage'],
            'value'            => ['required', 'numeric', 'min:0.01'],
            'usage_limit'      => ['nullable', 'integer', 'min:1'],
            'min_order_amount' => ['nullable', 'numeric', 'min:0'],
            'assigned_to'      => ['nullable', 'exists:customers,id'],
            'expiry_date'      => ['nullable', 'date'],
            'is_active'        => ['nullable', 'boolean'],
            'notes'            => ['nullable', 'string', 'max:500'],
        ]);

        $validated['code']             = strtoupper($validated['code']);
$validated['is_active']        = $request->boolean('is_active', true);
$validated['min_order_amount'] = $validated['min_order_amount'] ?? 0;
$validated['usage_limit']      = $validated['usage_limit']      ?? null;
$validated['assigned_to']      = $validated['assigned_to']      ?? null;
$validated['expiry_date']      = $validated['expiry_date']      ?? null;
$validated['notes']            = $validated['notes']            ?? null;

        if ($validated['type'] === 'percentage' && $validated['value'] > 100) {
            return back()->withInput()
                ->withErrors(['value' => 'Percentage cannot exceed 100%.']);
        }

        $voucher->update($validated);
        $voucher->refresh()->load('assignedCustomer');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Voucher {$voucher->code} updated!",
                'voucher' => $this->_formatVoucher($voucher),
            ]);
        }

        return redirect()->route('vouchers.index')->with('success', "Voucher {$voucher->code} updated!");
    }

    // -----------------------------------------------
    // DELETE /vouchers/{voucher}
    // -----------------------------------------------
    public function destroy(Voucher $voucher)
    {
        abort_if(
            $voucher->shop_id !== auth()->user()->active_shop_id,
            403
        );

        $code = $voucher->code;
        $id   = $voucher->id;
        $voucher->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Voucher {$code} deleted.",
                'id'      => $id,
            ]);
        }

        return redirect()->route('vouchers.index')->with('success', "Voucher {$code} deleted.");
    }

    // -----------------------------------------------
    // GET /vouchers/{voucher}/print  — thermal print HTML
    // -----------------------------------------------
    public function printVoucher(Voucher $voucher)
    {
        abort_if($voucher->shop_id !== auth()->user()->active_shop_id, 403);
        $shop = auth()->user()->activeShop;
        return view('vouchers.print', compact('voucher', 'shop'));
    }

    // -----------------------------------------------
    // POST /vouchers/{voucher}/email
    // -----------------------------------------------
    public function emailVoucher(\Illuminate\Http\Request $request, Voucher $voucher)
    {
        abort_if($voucher->shop_id !== auth()->user()->active_shop_id, 403);

        $request->validate([
            'email'   => ['required', 'email'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        try {
            \Illuminate\Support\Facades\Mail::send(
                [],
                [],
                function ($m) use ($request, $voucher) {
                    $m->to($request->email)
                      ->subject($request->subject)
                      ->html(
                          view('vouchers.email', [
                              'voucher' => $voucher,
                              'message' => $request->message,
                              'shop'    => auth()->user()->activeShop,
                          ])->render()
                      );
                }
            );

            return response()->json(['success' => true, 'message' => 'Voucher sent to ' . $request->email]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to send: ' . $e->getMessage()], 500);
        }
    }

    // -----------------------------------------------
    // POST /api/vouchers/validate
    // AJAX — validate voucher code
    // Used by POS + Repair
    // -----------------------------------------------
    public function validateVoucher(Request $request): JsonResponse
    {
        $shopId = auth()->user()->active_shop_id;

        $request->validate([
            'code'        => ['required', 'string'],
            'total'       => ['required', 'numeric', 'min:0'],
            'customer_id' => ['nullable', 'integer'],
        ]);

        $result = $this->voucherService->validate(
            code      : $request->code,
            shopId    : $shopId,
            total     : (float) $request->total,
            customerId: $request->customer_id
                ? (int) $request->customer_id
                : null
        );

        return response()->json($result);
    }

    // -----------------------------------------------
    // Private — format voucher for JSON
    // -----------------------------------------------
    private function _formatVoucher(Voucher $v): array
    {
        $expired = $v->expiry_date && \Carbon\Carbon::parse($v->expiry_date)->isPast();
        $used    = $v->usage_limit && $v->used_count >= $v->usage_limit;
        $active  = $v->is_active && !$expired && !$used;
        return [
            'id'               => $v->id,
            'code'             => $v->code,
            'type'             => $v->type,
            'value'            => (float) $v->value,
            'formatted_value'  => $v->formatted_value,
            'usage_limit'      => $v->usage_limit,
            'used_count'       => $v->used_count,
            'min_order_amount' => (float) $v->min_order_amount,
            'assigned_to'      => $v->assigned_to,
            'customer_name'    => $v->assignedCustomer?->name,
            'expiry_date'      => $v->expiry_date,
            'is_active'        => (bool) $v->is_active,
            'notes'            => $v->notes,
            'is_expired'       => $expired,
            'is_used'          => $used,
            'status'           => $active ? 'active' : ($expired ? 'expired' : ($used ? 'used' : 'inactive')),
            'edit_url'         => route('vouchers.edit', $v->id),
            'delete_url'       => route('vouchers.destroy', $v->id),
            'created_at'       => $v->created_at->format('d/m/Y'),
        ];
    }

    // -----------------------------------------------
    // GET /api/vouchers
    // AJAX — list active vouchers for dropdown
    // -----------------------------------------------
    public function list(): JsonResponse
    {
        $shopId   = auth()->user()->active_shop_id;
        $vouchers = Voucher::forShop($shopId)
            ->valid()
            ->orderBy('code')
            ->get(['id', 'code', 'type', 'value'])
            ->map(fn($v) => [
                'id'        => $v->id,
                'code'      => $v->code,
                'formatted' => $v->formatted_value,
                'label'     => "{$v->code} — {$v->formatted_value} off",
            ]);

        return response()->json($vouchers);
    }
}