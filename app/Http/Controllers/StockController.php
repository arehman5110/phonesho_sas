<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\StockMovement;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StockController extends Controller
{
    public function __construct(
        protected StockService $stockService,
    ) {}

    // -----------------------------------------------
    // GET /products/stock
    // -----------------------------------------------
    public function index(Request $request)
    {
        $shopId = auth()->user()->active_shop_id;

        $query = Product::where('shop_id', $shopId)
            ->with(['category', 'brand'])
            ->where('is_active', true);

        // ── Search ────────────────────────────────
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('name',  'like', "%{$term}%")
                  ->orWhere('sku', 'like', "%{$term}%");
            });
        }

        // ── Category filter ───────────────────────
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // ── Stock filter ──────────────────────────
        if ($request->filled('stock_filter')) {
            match($request->stock_filter) {
                'low'  => $query->whereColumn('stock', '<=', 'low_stock_alert')
                                ->where('stock', '>', 0),
                'out'  => $query->where('stock', '<=', 0),
                'ok'   => $query->whereColumn('stock', '>', 'low_stock_alert'),
                default => null,
            };
        }

        $products = $query->orderBy('name')->paginate(30)->withQueryString();

        $categories = Category::where('shop_id', $shopId)
            ->orderBy('name')
            ->get(['id', 'name']);

        // Summary stats
        $stats = [
            'total'    => Product::where('shop_id', $shopId)->where('is_active', true)->count(),
            'low'      => Product::where('shop_id', $shopId)->where('is_active', true)
                            ->whereColumn('stock', '<=', 'low_stock_alert')
                            ->where('stock', '>', 0)->count(),
            'out'      => Product::where('shop_id', $shopId)->where('is_active', true)
                            ->where('stock', '<=', 0)->count(),
        ];

        return view('products.stock', compact(
            'products',
            'categories',
            'stats'
        ));
    }

    // -----------------------------------------------
    // POST /products/{product}/topup
    // -----------------------------------------------
    public function topup(Request $request, Product $product): JsonResponse
    {
        // Ensure product belongs to active shop
        abort_if(
            $product->shop_id !== auth()->user()->active_shop_id,
            403
        );

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:9999'],
            'note'     => ['nullable', 'string', 'max:500'],
        ]);

        try {
            $this->stockService->addStock(
                product : $product,
                quantity: (int) $validated['quantity'],
                type    : 'manual',
                note    : $validated['note'] ?? 'Manual stock top-up',
            );

            $product->refresh();

            return response()->json([
                'success'      => true,
                'message'      => "Added {$validated['quantity']} units to {$product->name}",
                'new_stock'    => $product->stock,
                'product_id'   => $product->id,
                'is_low'       => $product->stock > 0
                    && $product->stock <= ($product->low_stock_alert ?? 5),
                'is_out'       => $product->stock <= 0,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update stock: ' . $e->getMessage(),
            ], 500);
        }
    }

    // -----------------------------------------------
    // GET /products/{product}/movements
    // Stock movement history (AJAX)
    // -----------------------------------------------
    public function movements(Product $product): JsonResponse
    {
        abort_if(
            $product->shop_id !== auth()->user()->active_shop_id,
            403
        );

        $movements = StockMovement::where('product_id', $product->id)
            ->with('user')
            ->latest()
            ->limit(20)
            ->get()
            ->map(fn($m) => [
                'id'         => $m->id,
                'type'       => $m->type,
                'quantity'   => $m->quantity,
                'note'       => $m->note,
                'user'       => $m->user?->name ?? 'System',
                'created_at' => $m->created_at->format('d/m/Y H:i'),
            ]);

        return response()->json([
            'product'   => $product->name,
            'stock'     => $product->stock,
            'movements' => $movements,
        ]);
    }
}