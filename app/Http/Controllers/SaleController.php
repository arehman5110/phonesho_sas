<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\ShopSetting;
use App\Services\SaleService;
use App\Services\PaymentService;
use App\Http\Requests\StoreSaleRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReceiptMail;

class SaleController extends Controller
{
    public function __construct(
        protected SaleService    $saleService,
        protected PaymentService $paymentService,
    ) {}

    // -----------------------------------------------
    // GET /sales
    // -----------------------------------------------
    public function index(Request $request): mixed
    {
        $shopId = auth()->user()->active_shop_id;

        if (!$shopId) {
            return redirect()->route('shop.select')
                ->with('error', 'Please select a shop first.');
        }

        $query = Sale::forShop($shopId)
            ->with(['customer', 'items', 'payments', 'createdBy']);

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('reference', 'like', "%{$term}%")
                  ->orWhereHas('customer', fn($c) =>
                      $c->where('name',  'like', "%{$term}%")
                        ->orWhere('phone', 'like', "%{$term}%")
                  );
            });
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $query->latest();

        if ($request->ajax() || $request->wantsJson()) {
            $sales = $query->paginate(20)->withQueryString();
            return response()->json([
                'sales'      => $sales->map(fn($s) => $this->_formatSale($s)),
                'pagination' => [
                    'total'        => $sales->total(),
                    'current_page' => $sales->currentPage(),
                    'last_page'    => $sales->lastPage(),
                    'from'         => $sales->firstItem(),
                    'to'           => $sales->lastItem(),
                ],
            ]);
        }

        $sales = $query->paginate(20)->withQueryString();
        return view('sales.index', compact('sales'));
    }

    // -----------------------------------------------
    // GET /pos
    // -----------------------------------------------
    public function pos()
    {
        return view('pos.index');
    }

    // -----------------------------------------------
    // POST /pos
    // -----------------------------------------------
    public function store(StoreSaleRequest $request): JsonResponse
    {
        $shopId    = auth()->user()->active_shop_id;
        $validated = $request->validated();

        try {
            $sale = $this->saleService->createSale(
                data : array_merge($validated, ['shop_id' => $shopId]),
                items: $validated['items'] ?? []
            );

            $summary = $this->paymentService->getSaleSummary($sale);

            return response()->json([
                'success'        => true,
                'message'        => "Sale {$sale->reference} completed!",
                'sale_id'        => $sale->id,
                'reference'      => $sale->reference,
                'summary'        => $summary,
                'customer_email' => $sale->customer?->email,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to complete sale: ' . $e->getMessage(),
            ], 500);
        }
    }

    // -----------------------------------------------
    // GET /sales/{sale}/receipt
    // -----------------------------------------------
    public function receipt(Sale $sale): mixed
    {
        abort_if($sale->shop_id !== auth()->user()->active_shop_id, 403);

        $sale->load(['items.product', 'customer', 'payments', 'createdBy', 'shop']);

        $summary  = $this->paymentService->getSaleSummary($sale);
        $settings = ShopSetting::getAllForShop($sale->shop_id);

        return view('pos.receipt', compact('sale', 'summary', 'settings'));
    }

    // -----------------------------------------------
    // POST /sales/{sale}/email
    // -----------------------------------------------
    public function emailReceipt(Request $request, Sale $sale): JsonResponse
    {
        abort_if($sale->shop_id !== auth()->user()->active_shop_id, 403);

        $validated = $request->validate([
            'email'   => ['required', 'email'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        try {
            $sale->loadMissing(['items.product', 'customer', 'payments', 'createdBy', 'shop']);

            Mail::to($validated['email'])
                ->send(new ReceiptMail(
                    $sale,
                    $validated['subject'],
                    $validated['message'] ?? null,
                ));

            return response()->json([
                'success' => true,
                'message' => "Receipt sent to {$validated['email']}",
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send: ' . $e->getMessage(),
            ], 500);
        }
    }

    // -----------------------------------------------
    // GET /pos/{sale}/summary
    // -----------------------------------------------
    public function summary(Sale $sale): JsonResponse
    {
        abort_if($sale->shop_id !== auth()->user()->active_shop_id, 403);
        return response()->json($this->paymentService->getSaleSummary($sale));
    }

    // -----------------------------------------------
    // Format sale for JSON
    // -----------------------------------------------
    private function _formatSale(Sale $sale): array
    {
        $totalPaid   = $sale->payments->sum('amount');
        $outstanding = max(0, (float) $sale->final_amount - $totalPaid);

        return [
            'id'             => $sale->id,
            'reference'      => $sale->reference,
            'customer'       => $sale->customer ? [
                'name'  => $sale->customer->name,
                'phone' => $sale->customer->phone,
            ] : null,
            'items_count'    => $sale->items->count(),
            'items'          => $sale->items->map(fn($i) => [
                'name'       => $i->product_name,
                'quantity'   => $i->quantity,
                'price'      => $i->price,
                'line_total' => $i->line_total,
            ]),
            'total_amount'   => (float) $sale->total_amount,
            'discount'       => (float) $sale->discount,
            'final_amount'   => (float) $sale->final_amount,
            'payment_status' => $sale->payment_status,
            'payment_method' => $sale->payment_method,
            'payments'       => $sale->payments->map(fn($p) => [
                'method'     => $p->method,
                'split_part' => $p->split_part,
                'amount'     => (float) $p->amount,
                'note'       => $p->note,
            ]),
            'outstanding'    => $outstanding,
            'created_by'     => $sale->createdBy?->name,
            'created_at'     => $sale->created_at->format('d/m/Y H:i'),
            'receipt_url'    => route('sales.receipt', $sale->id),
        ];
    }
}