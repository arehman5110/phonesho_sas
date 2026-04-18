<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceTransaction;
use App\Models\DevicePayment;
use App\Models\Brand;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class BuySellController extends Controller
{
    // -----------------------------------------------
    // GET /buy-sell  — index page
    // -----------------------------------------------
    public function index(Request $request)
    {
        $shopId = auth()->user()->active_shop_id;

        $query = Device::forShop($shopId)
            ->with(['brand', 'buyTransaction.customer', 'transactions'])
            ->latest();

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('model_name', 'like', "%{$term}%")
                  ->orWhere('imei', 'like', "%{$term}%")
                  ->orWhere('serial_number', 'like', "%{$term}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        $devices = $query->paginate(20)->withQueryString();

        $stats = [
            'total'       => Device::forShop($shopId)->count(),
            'in_stock'    => Device::forShop($shopId)->inStock()->count(),
            'sold'        => Device::forShop($shopId)->sold()->count(),
            'total_value' => Device::forShop($shopId)->inStock()->sum('purchase_price'),
        ];

        $brands    = Brand::where('shop_id', $shopId)->active()->ordered()->get();
        $customers = Customer::forShop($shopId)->orderBy('name')->get(['id','name','phone','email']);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'html'  => view('buy-sell.partials.device-list', compact('devices'))->render(),
                'stats' => $stats,
            ]);
        }

        return view('buy-sell.index', compact('devices', 'stats', 'brands', 'customers'));
    }

    // -----------------------------------------------
    // GET /buy-sell/create  — buy device form page
    // -----------------------------------------------
    public function create()
    {
        $shopId    = auth()->user()->active_shop_id;
        $brands    = Brand::where('shop_id', $shopId)->active()->ordered()->get();
        $customers = Customer::forShop($shopId)->orderBy('name')->get(['id','name','phone','email']);
        return view('buy-sell.create', compact('brands', 'customers'));
    }

    // -----------------------------------------------
    // GET /buy-sell/{device}/sell  — sell device form page
    // -----------------------------------------------
    public function sellPage(Device $device)
    {
        abort_if($device->shop_id !== auth()->user()->active_shop_id, 403);
        abort_if($device->status !== 'in_stock', 422, 'Device is not available for sale.');
        $device->load(['brand', 'buyTransaction.customer']);
        $customers = Customer::forShop($device->shop_id)->orderBy('name')->get(['id','name','phone','email']);
        return view('buy-sell.sell', compact('device', 'customers'));
    }

    // -----------------------------------------------
    // POST /buy-sell/buy  — record one or many purchases
    // Accepts: { devices: [...], customer_id, payment_method, payment_status }
    // -----------------------------------------------
    public function buy(Request $request): JsonResponse
    {
        $shopId = auth()->user()->active_shop_id;

        $request->validate([
            'devices'                    => ['required', 'array', 'min:1'],
            'devices.*.model_name'       => ['required', 'string', 'max:200'],
            'devices.*.brand_name'       => ['nullable', 'string', 'max:100'],
            'devices.*.imei'             => ['nullable', 'string', 'max:20', 'unique:devices,imei'],
            'devices.*.serial_number'    => ['nullable', 'string', 'max:100'],
            'devices.*.condition'        => ['required', 'in:new,used,faulty,refurbished'],
            'devices.*.storage'          => ['nullable', 'string', 'max:50'],
            'devices.*.color'            => ['nullable', 'string', 'max:50'],
            'devices.*.purchase_price'   => ['required', 'numeric', 'min:0'],
            'devices.*.selling_price'    => ['nullable', 'numeric', 'min:0'],
            'devices.*.notes'            => ['nullable', 'string', 'max:1000'],
            'customer_id'                => ['nullable', 'exists:customers,id'],
            'payment_method'             => ['required', 'string'],
            'payment_status'             => ['required', 'in:unpaid,partial,paid'],
        ]);

        $devices        = $request->input('devices');
        $customerId     = $request->input('customer_id');
        $paymentMethod  = $request->input('payment_method');
        $paymentStatus  = $request->input('payment_status');

        return DB::transaction(function () use ($devices, $customerId, $paymentMethod, $paymentStatus, $shopId) {
            $created = [];

            foreach ($devices as $d) {
                // Resolve / create brand
                $brandId = null;
                if (!empty($d['brand_name'])) {
                    $brand   = Brand::firstOrCreate(
                        ['shop_id' => $shopId, 'name' => $d['brand_name']],
                        ['slug' => \Str::slug($d['brand_name']), 'is_active' => true]
                    );
                    $brandId = $brand->id;
                }

                $device = Device::create([
                    'shop_id'        => $shopId,
                    'brand_id'       => $brandId,
                    'model_name'     => $d['model_name'],
                    'imei'           => $d['imei']           ?? null,
                    'serial_number'  => $d['serial_number']  ?? null,
                    'condition'      => $d['condition'],
                    'storage'        => $d['storage']        ?? null,
                    'color'          => $d['color']          ?? null,
                    'purchase_price' => $d['purchase_price'],
                    'selling_price'  => $d['selling_price']  ?? null,
                    'status'         => 'in_stock',
                    'notes'          => $d['notes']          ?? null,
                ]);

                $finalAmount = (float) $d['purchase_price'];

                $transaction = DeviceTransaction::create([
                    'device_id'      => $device->id,
                    'type'           => 'buy',
                    'customer_id'    => $customerId,
                    'price'          => $finalAmount,
                    'discount'       => 0,
                    'final_amount'   => $finalAmount,
                    'payment_status' => $paymentStatus,
                    'notes'          => $d['notes'] ?? null,
                ]);

                if ($paymentStatus !== 'unpaid') {
                    DevicePayment::create([
                        'transaction_id' => $transaction->id,
                        'method'         => $paymentMethod,
                        'amount'         => $finalAmount,
                        'note'           => null,
                    ]);
                }

                $created[] = $device->model_name;
            }

            $count = count($created);
            $msg   = $count === 1
                ? "Device \"{$created[0]}\" added to stock!"
                : "{$count} devices added to stock!";

            return response()->json(['success' => true, 'message' => $msg, 'count' => $count]);
        });
    }

    // -----------------------------------------------
    // POST /buy-sell/{device}/sell
    // -----------------------------------------------
    public function sell(Request $request, Device $device): JsonResponse
    {
        abort_if($device->shop_id !== auth()->user()->active_shop_id, 403);
        abort_if($device->status !== 'in_stock', 422, 'Device is not available for sale.');

        $validated = $request->validate([
            'selling_price'  => ['required', 'numeric', 'min:0.01'],
            'discount'       => ['nullable', 'numeric', 'min:0'],
            'customer_id'    => ['nullable', 'exists:customers,id'],
            'payment_method' => ['required', 'string'],
            'payment_status' => ['required', 'in:unpaid,partial,paid'],
            'notes'          => ['nullable', 'string', 'max:1000'],
        ]);

        return DB::transaction(function () use ($validated, $device, $request) {
            $sellPrice   = (float) $validated['selling_price'];
            $discount    = (float) ($validated['discount'] ?? 0);
            $finalAmount = max(0, $sellPrice - $discount);

            $device->update([
                'selling_price' => $sellPrice,
                'status'        => 'sold',
            ]);

            $transaction = DeviceTransaction::create([
                'device_id'      => $device->id,
                'type'           => 'sell',
                'customer_id'    => $validated['customer_id'] ?? null,
                'price'          => $sellPrice,
                'discount'       => $discount,
                'final_amount'   => $finalAmount,
                'payment_status' => $validated['payment_status'],
                'notes'          => $validated['notes'] ?? null,
            ]);

            if ($validated['payment_status'] !== 'unpaid') {
                $paidAmount = $validated['payment_status'] === 'paid'
                    ? $finalAmount
                    : (float) ($request->paid_amount ?? 0);

                DevicePayment::create([
                    'transaction_id' => $transaction->id,
                    'method'         => $validated['payment_method'],
                    'amount'         => $paidAmount,
                    'note'           => null,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => "Device \"{$device->model_name}\" sold for £" . number_format($finalAmount, 2) . "!",
                'device'  => $this->_formatDevice($device->fresh()->load(['brand', 'transactions'])),
                'profit'  => $device->fresh()->profit,
            ]);
        });
    }

    // -----------------------------------------------
    // DELETE /buy-sell/{device}
    // -----------------------------------------------
    public function destroy(Device $device)
    {
        abort_if($device->shop_id !== auth()->user()->active_shop_id, 403);
        $name = $device->model_name;
        $device->delete();
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => "Device '{$name}' removed."]);
        }
        return redirect()->route('buy-sell.index')->with('success', "Device '{$name}' removed.");
    }

    // -----------------------------------------------
    // Private helpers
    // -----------------------------------------------
    private function _formatDevice(Device $d): array
    {
        $buy = $d->transactions->where('type', 'buy')->first();
        return [
            'id'              => $d->id,
            'model_name'      => $d->model_name,
            'brand'           => $d->brand?->name,
            'imei'            => $d->imei,
            'serial_number'   => $d->serial_number,
            'condition'       => $d->condition,
            'condition_label' => $d->condition_label,
            'storage'         => $d->storage,
            'color'           => $d->color,
            'status'          => $d->status,
            'purchase_price'  => (float) $d->purchase_price,
            'selling_price'   => $d->selling_price ? (float) $d->selling_price : null,
            'profit'          => $d->profit,
            'notes'           => $d->notes,
            'created_at'      => $d->created_at->format('d/m/Y'),
            'sell_url'        => route('buy-sell.sell', $d->id),
            'delete_url'      => route('buy-sell.destroy', $d->id),
        ];
    }
}