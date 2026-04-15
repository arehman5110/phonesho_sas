<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use App\Models\Status;
use App\Models\DeviceType;
use App\Models\User;
use App\Services\RepairService;
use App\Http\Requests\StoreRepairRequest;
use Illuminate\Http\Request;
use App\Models\ShopSetting;
use App\Models\RepairType;

class RepairController extends Controller
{
    public function __construct(protected RepairService $repairService) {}

    // -----------------------------------------------
    // GET /repairs
    // -----------------------------------------------
    public function index(Request $request)
    {
        $shopId = auth()->user()->active_shop_id;

        $query = Repair::forShop($shopId)->with([
            'customer',
            'status',
            'devices.deviceType',
            'devices.parts.product',
            'payments',
            'createdBy',
            'assignedTo',
            'parentRepair', // ← add
        ]);

        // ── Search ────────────────────────────────────
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // ── Status filter (multiple) ──────────────────
        if ($request->filled('statuses')) {
            $statusIds = is_array($request->statuses) ? $request->statuses : explode(',', $request->statuses);

            $query->whereIn('status_id', $statusIds);
        }

        // ── Date range ────────────────────────────────
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // ── Sort ──────────────────────────────────────
        $query->latest();

        // ── AJAX response ─────────────────────────────
        if ($request->ajax() || $request->wantsJson()) {
            $repairs = $query->paginate(20)->withQueryString();

            return response()->json([
                'repairs' => $repairs->map(fn($r) => $this->_formatRepair($r)),
                'pagination' => [
                    'total' => $repairs->total(),
                    'current_page' => $repairs->currentPage(),
                    'last_page' => $repairs->lastPage(),
                    'from' => $repairs->firstItem(),
                    'to' => $repairs->lastItem(),
                ],
            ]);
        }

        // ── Normal page load ──────────────────────────
        $repairs = $query->paginate(20)->withQueryString();

        $statuses = Status::forShop($shopId)->ofType('repair')->active()->ordered()->get();

        return view('repairs.index', compact('repairs', 'statuses'));
    }

    // -----------------------------------------------
    // Format repair for JSON response
    // -----------------------------------------------
    private function _formatRepair(Repair $repair): array
    {
        return [
            'id' => $repair->id,
            'reference' => $repair->reference,
            'is_warranty_return' => $repair->is_warranty_return, // ← add
            'parent_reference' => $repair->parentRepair?->reference, // ← add
            'parent_url' => $repair->parentRepair // ← add
                ? route('repairs.show', $repair->parentRepair->id)
                : null,
            'customer' => $repair->customer
                ? [
                    'name' => $repair->customer->name,
                    'phone' => $repair->customer->phone,
                ]
                : null,
            'devices' => $repair->devices->map(
                fn($d) => [
                    'id' => $d->id,
                    'device_name' => $d->device_name,
                    'device_type' => $d->deviceType?->name,
                    'imei' => $d->imei,
                    'color' => $d->color,
                    'issue' => $d->issue,
                    'repair_type' => $d->repair_type,
                    'warranty' => $d->warranty_label,
                    'price' => $d->price,
                    'notes' => $d->notes,
                    'parts' => $d->parts->map(
                        fn($p) => [
                            'name' => $p->name,
                            'quantity' => $p->quantity,
                            'product_id' => $p->product_id,
                        ],
                    ),
                ],
            ),
            'status' => $repair->status
                ? [
                    'id' => $repair->status->id,
                    'name' => $repair->status->name,
                    'color' => $repair->status->color,
                ]
                : null,
            'total_price' => $repair->total_price,
            'discount' => $repair->discount,
            'final_price' => $repair->final_price,
            'payments' => $repair->payments->map(
                fn($p) => [
                    'method' => $p->method,
                    'split_part' => $p->split_part,
                    'amount' => $p->amount,
                    'note' => $p->note,
                ],
            ),
            'delivery_type' => $repair->delivery_type_label,
            'book_in_date' => $repair->book_in_date?->format('d/m/Y'),
            'completion_date' => $repair->completion_date?->format('d/m/Y'),
            'assigned_to' => $repair->assignedTo?->name,
            'created_by' => $repair->createdBy?->name,
            'notes' => $repair->notes,
            'created_at' => $repair->created_at->format('d/m/Y H:i'),
            'show_url' => route('repairs.show', $repair->id),
            'receipt_url' => route('repairs.receipt', $repair->id),
        ];
    }

    // -----------------------------------------------
    // GET /repairs/create
    // -----------------------------------------------
    public function create()
{
    $shopId = auth()->user()->active_shop_id;

    $statuses = Status::forShop($shopId)
        ->ofType('repair')
        ->active()
        ->ordered()
        ->get();

    $deviceTypes = DeviceType::forShop($shopId)
        ->active()
        ->ordered()
        ->get();

    $staff = User::whereHas('shops', function ($q) use ($shopId) {
        $q->where('shop_id', $shopId);
    })->orderBy('name')->get();

    $issueSuggestions = $this->_getIssueSuggestions();

    // Popular repair types for suggestions
    $repairTypes = RepairType::forShop($shopId)
        ->popular()
        ->limit(20)
        ->get(['id', 'name']);

    // Device statuses
    $deviceStatuses = Status::forShop($shopId)
        ->ofType('repair')
        ->active()
        ->ordered()
        ->get();

    // Pre-render device card template
    $deviceCardTemplate = view('repairs.partials.device-card', [
        'deviceTypes'    => $deviceTypes,
        'issueSuggestions' => $issueSuggestions,
        'repairTypes'    => $repairTypes,
        'deviceStatuses' => $deviceStatuses,
    ])->render();

    return view('repairs.create', compact(
        'statuses',
        'deviceTypes',
        'staff',
        'issueSuggestions',
        'repairTypes',
        'deviceStatuses',
        'deviceCardTemplate'
    ));
}

    // -----------------------------------------------
    // POST /repairs
    // -----------------------------------------------
    public function store(StoreRepairRequest $request)
    {
        $shopId = auth()->user()->active_shop_id;

        // Guard — should never happen but safety first
        if (!$shopId) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'No active shop selected.']);
        }

        $validated = $request->validated();

        try {
            $repair = $this->repairService->createRepair(
                array_merge($validated, [
                    'shop_id' => $shopId,
                    'is_warranty_return' => $request->boolean('is_warranty_return'),
                    'parent_repair_id' => $request->input('parent_repair_id') ?: null,
                ]),
            );

            return redirect()
                ->route('repairs.index')
                ->with('success', "Repair {$repair->reference} created successfully!");
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors([
                    'error' => 'Failed to create repair: ' . $e->getMessage(),
                ]);
        }
    }

    // -----------------------------------------------
    // GET /repairs/{repair}
    // -----------------------------------------------
    public function show(Repair $repair)
    {
        abort_if($repair->shop_id !== auth()->user()->active_shop_id, 403);

        $repair->load(['customer', 'status', 'devices.deviceType', 'devices.parts.product', 'devices.status', 'payments', 'createdBy', 'assignedTo']);

        $summary = $this->repairService->getSummary($repair);

        return view('repairs.show', compact('repair', 'summary'));
    }

    // -----------------------------------------------
    // GET /repairs/{repair}/receipt
    // -----------------------------------------------
    public function receipt(Repair $repair)
    {
        abort_if($repair->shop_id !== auth()->user()->active_shop_id, 403);

        $repair->load(['customer', 'status', 'devices.deviceType', 'devices.parts.product', 'payments', 'createdBy', 'assignedTo', 'shop']);

        $summary = $this->repairService->getSummary($repair);
        $settings = \App\Models\ShopSetting::getAllForShop($repair->shop_id);

        return view('repairs.receipt', compact('repair', 'summary', 'settings'));
    }

    // -----------------------------------------------
    // POST /repairs/{repair}/email
    // -----------------------------------------------
    public function emailReceipt(Repair $repair)
    {
        abort_if($repair->shop_id !== auth()->user()->active_shop_id, 403);

        if (!$repair->customer || !$repair->customer->email) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'No customer email address found.',
                ],
                422,
            );
        }

        try {
            $repair->loadMissing(['customer', 'status', 'devices.deviceType', 'devices.parts.product', 'payments', 'createdBy', 'shop']);

            \Illuminate\Support\Facades\Mail::to($repair->customer->email)->send(new \App\Mail\RepairReceiptMail($repair));

            return response()->json([
                'success' => true,
                'message' => "Receipt sent to {$repair->customer->email}",
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Failed to send email: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }

    // -----------------------------------------------
    // GET /repairs/warranty-search
    // AJAX — search previous repairs for warranty
    // -----------------------------------------------
    public function warrantySearch(Request $request)
    {
        $shopId = auth()->user()->active_shop_id;
        $term = $request->input('q', '');

        if (strlen($term) < 2) {
            return response()->json([]);
        }

        $repairs = Repair::forShop($shopId)
            ->with(['customer', 'devices.deviceType', 'devices.parts', 'status'])
            ->where(function ($query) use ($term) {
                // Search by reference
                $query
                    ->where('reference', 'like', "%{$term}%")

                    // Search by customer name/phone
                    ->orWhereHas('customer', fn($q) => $q->where('name', 'like', "%{$term}%")->orWhere('phone', 'like', "%{$term}%"))

                    // Search by device IMEI or name
                    ->orWhereHas('devices', fn($q) => $q->where('imei', 'like', "%{$term}%")->orWhere('device_name', 'like', "%{$term}%"));
            })
            // Only show non-warranty repairs as candidates
            ->where('is_warranty_return', false)
            ->latest()
            ->limit(5)
            ->get();

        return response()->json($repairs->map(fn($r) => $this->_formatWarrantyRepair($r)));
    }

    // -----------------------------------------------
    // GET /api/repair-types
    // AJAX — search repair types
    // -----------------------------------------------
    public function repairTypes(Request $request)
    {
        $shopId = auth()->user()->active_shop_id;
        $term = $request->input('q', '');

        $types = RepairType::forShop($shopId)
            ->when($term, fn($q) => $q->search($term))
            ->popular()
            ->limit(10)
            ->get(['id', 'name', 'used_count']);

        return response()->json($types);
    }

    // -----------------------------------------------
    // Format repair for warranty search results
    // -----------------------------------------------
    private function _formatWarrantyRepair(Repair $repair): array
    {
        return [
            'id' => $repair->id,
            'reference' => $repair->reference,
            'date' => $repair->created_at->format('d/m/Y'),
            'customer' => $repair->customer
                ? [
                    'name' => $repair->customer->name,
                    'phone' => $repair->customer->phone,
                ]
                : null,
            'status' => $repair->status?->name,
            'devices' => $repair->devices->map(
                fn($d) => [
                    'id' => $d->id,
                    'device_name' => $d->device_name,
                    'device_type' => $d->deviceType?->name,
                    'imei' => $d->imei,
                    'color' => $d->color,
                    'issue' => $d->issue,
                    'repair_type' => $d->repair_type,
                    'warranty_status' => $d->warranty_status,
                    'warranty_expiry_date' => $d->warranty_expiry_date?->format('d/m/Y'),
                    'warranty_days' => $d->warranty_days,
                    'is_under_warranty' => $d->isUnderWarranty(),
                    'days_remaining' => $d->warrantyDaysRemaining(),
                    'price' => $d->price,
                ],
            ),
        ];
    }

    // -----------------------------------------------
    // Issue suggestions list
    // -----------------------------------------------
    private function _getIssueSuggestions(): array
    {
        return ['Screen Cracked', 'Screen Not Working', 'Battery Draining Fast', 'Battery Not Charging', 'Charging Port Fault', 'Speaker Not Working', 'Microphone Not Working', 'Camera Not Working', 'Front Camera Fault', 'Back Camera Fault', 'Water Damage', 'Power Button Fault', 'Volume Button Fault', 'Home Button Fault', 'Face ID Not Working', 'Touch ID Not Working', 'Wifi Not Working', 'Bluetooth Not Working', 'No Signal / No Service', 'Software Issue', 'Phone Not Turning On', 'Overheating', 'Back Glass Cracked', 'Earpiece Not Working', 'Vibration Not Working'];
    }

    //     public function index(Request $request)
    // {
    //     $shopId = auth()->user()->active_shop_id;

    //     $repairs = Repair::forShop($shopId)
    //         ->with(['customer', 'status', 'devices', 'createdBy', 'assignedTo'])
    //         ->when($request->search, fn($q) => $q->search($request->search))
    //         ->when($request->status_id, fn($q) => $q->byStatus($request->status_id))
    //         ->when($request->date_from, fn($q) =>
    //             $q->whereDate('created_at', '>=', $request->date_from)
    //         )
    //         ->when($request->date_to, fn($q) =>
    //             $q->whereDate('created_at', '<=', $request->date_to)
    //         )
    //         ->latest()
    //         ->paginate(20)
    //         ->withQueryString();

    //     $statuses = Status::forShop($shopId)
    //         ->ofType('repair')
    //         ->active()
    //         ->ordered()
    //         ->get();

    //     return view('repairs.index', compact('repairs', 'statuses'));
    // }
}
