<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    // -----------------------------------------------
    // GET /api/products?search=
    // Used by POS + repair parts search
    // -----------------------------------------------
    public function search(Request $request): JsonResponse
{
    $shopId = auth()->user()->active_shop_id;
    $term   = $request->input('search', '');

    $query = Product::where('shop_id', $shopId)
        ->where('is_active', true)
        ->with(['category', 'brand']);

    // ── Filter by category ────────────────────────────────
    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    // ── Filter by brand ───────────────────────────────────
    if ($request->filled('brand_id')) {
        $query->where('brand_id', $request->brand_id);
    }

    // ── Text search ───────────────────────────────────────
    if ($term) {
        $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('sku',  'like', "%{$term}%");
        });
    }

    $products = $query->orderBy('name')->limit(50)->get();

    return response()->json(
        $products->map(fn($p) => $this->_formatProduct($p))
    );
}
    // -----------------------------------------------
    // GET /products/search?q=
    // Used by product name autocomplete on create/edit
    // -----------------------------------------------
    public function autocomplete(Request $request): JsonResponse
    {
        $shopId = auth()->user()->active_shop_id;
        $term   = $request->input('q', '');

        if (strlen($term) < 1) {
            return response()->json([]);
        }

        $products = Product::where('shop_id', $shopId)
            ->with(['category', 'brand'])
            ->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('sku',  'like', "%{$term}%");
            })
            ->where('is_active', true)
            ->orderBy('name')
            ->limit(10)
            ->get();

        return response()->json(
            $products->map(fn($p) => [
                'id'            => $p->id,
                'name'          => $p->name,
                'sku'           => $p->sku,
                'category_id'   => $p->category_id,
                'category_name' => $p->category?->name,
                'brand_id'      => $p->brand_id,
                'brand_name'    => $p->brand?->name,
                'price'         => (float) $p->price,
                'cost_price'    => (float) $p->cost_price,
                'stock'         => (int) $p->stock,
                'low_stock_alert' => (int) $p->low_stock_alert,
                'is_active'     => (bool) $p->is_active,
                'formatted_price' => '£' . number_format($p->price, 2),
            ])
        );
    }

    // -----------------------------------------------
    // GET /products
    // -----------------------------------------------
    public function index(Request $request)
    {
        $shopId = auth()->user()->active_shop_id;

        // ── Base filtered query (search + category + brand) ─────
        // Used for both stats cards AND the table (stock_filter applied on top)
        $base = Product::where('shop_id', $shopId)->where('is_active', true);

        if ($request->filled('search')) {
            $term = $request->search;
            $base->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('sku',  'like', "%{$term}%");
            });
        }

        if ($request->filled('category_id')) {
            $base->where('category_id', $request->category_id);
        }

        if ($request->filled('brand_id')) {
            $base->where('brand_id', $request->brand_id);
        }

        // ── Stats from filtered base (no stock_filter so all 4 cards update) ──
        $stats = [
            'total'     => (clone $base)->count(),
            'in_stock'  => (clone $base)->where('stock', '>', 0)->count(),
            'low_stock' => (clone $base)->whereColumn('stock', '<=', 'low_stock_alert')->where('stock', '>', 0)->count(),
            'out_stock' => (clone $base)->where('stock', '<=', 0)->count(),
        ];

        // ── Table query = base + stock_filter ─────────────────
        $query = (clone $base)->with(['category', 'brand']);

        // ── Stock filter from top cards or dropdown ───────────
        if ($request->filled('stock_filter')) {
            match($request->stock_filter) {
                'low_stock' => $query->whereColumn('stock', '<=', 'low_stock_alert')->where('stock', '>', 0),
                'out_stock' => $query->where('stock', '<=', 0),
                'in_stock'  => $query->where('stock', '>', 0),
                default     => null,
            };
        }

        $products   = $query->orderBy('name')->paginate(20)->withQueryString();
        $categories = Category::where('shop_id', $shopId)->ordered()->get();
        $brands     = Brand::where('shop_id', $shopId)->ordered()->get();

        return view('products.index', compact(
            'products', 'categories', 'brands', 'stats'
        ));
    }

    // -----------------------------------------------
    // GET /products/create
    // -----------------------------------------------
    public function create()
    {
        $shopId     = auth()->user()->active_shop_id;
        $categories = Category::where('shop_id', $shopId)
            ->active()->ordered()->get();
        $brands     = Brand::where('shop_id', $shopId)
            ->active()->ordered()->get();

        return view('products.create', compact('categories', 'brands'));
    }

    // -----------------------------------------------
    // POST /products
    // -----------------------------------------------
    public function store(Request $request): mixed
    {
        $shopId = auth()->user()->active_shop_id;

        $validated = $request->validate([
            'name'            => ['required', 'string', 'max:200'],
            'sku'             => ['nullable', 'string', 'max:100'],
            'category_id'     => ['nullable', 'exists:categories,id'],
            'brand_id'        => ['nullable', 'exists:brands,id'],
            'price'           => ['required', 'numeric', 'min:0'],
            'cost_price'      => ['nullable', 'numeric', 'min:0'],
            'stock'           => ['required', 'integer', 'min:0'],
            'low_stock_alert' => ['nullable', 'integer', 'min:0'],
            'is_active'       => ['nullable', 'boolean'],
            'description'     => ['nullable', 'string', 'max:1000'],
        ]);

        $product = Product::create([
            'shop_id'         => $shopId,
            'name'            => $validated['name'],
            'sku'             => $validated['sku']             ?? null,
            'category_id'     => $validated['category_id']     ?? null,
            'brand_id'        => $validated['brand_id']        ?? null,
            'price'           => $validated['price'],
            'cost_price'      => $validated['cost_price']      ?? null,
            'stock'           => $validated['stock'],
            'low_stock_alert' => $validated['low_stock_alert'] ?? 5,
            'is_active'       => $request->boolean('is_active', true),
            'description'     => $validated['description']     ?? null,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Product \"{$product->name}\" created!",
                'product' => $this->_formatProduct($product->load(['category','brand'])),
            ]);
        }

        return redirect()
            ->route('products.index')
            ->with('success', "Product \"{$product->name}\" created!");
    }

    // -----------------------------------------------
    // GET /products/{product}/edit
    // -----------------------------------------------
    public function edit(Product $product)
    {
        abort_if($product->shop_id !== auth()->user()->active_shop_id, 403);

        $shopId     = auth()->user()->active_shop_id;
        $categories = Category::where('shop_id', $shopId)
            ->active()->ordered()->get();
        $brands     = Brand::where('shop_id', $shopId)
            ->active()->ordered()->get();

        return view('products.edit', compact('product', 'categories', 'brands'));
    }

    // -----------------------------------------------
    // PUT /products/{product}
    // -----------------------------------------------
    public function update(Request $request, Product $product): mixed
    {
        abort_if($product->shop_id !== auth()->user()->active_shop_id, 403);

        $validated = $request->validate([
            'name'            => ['required', 'string', 'max:200'],
            'sku'             => ['nullable', 'string', 'max:100'],
            'category_id'     => ['nullable', 'exists:categories,id'],
            'brand_id'        => ['nullable', 'exists:brands,id'],
            'price'           => ['required', 'numeric', 'min:0'],
            'cost_price'      => ['nullable', 'numeric', 'min:0'],
            'stock'           => ['required', 'integer', 'min:0'],
            'low_stock_alert' => ['nullable', 'integer', 'min:0'],
            'is_active'       => ['nullable', 'boolean'],
            'description'     => ['nullable', 'string', 'max:1000'],
        ]);

        $product->update([
            'name'            => $validated['name'],
            'sku'             => $validated['sku']             ?? null,
            'category_id'     => $validated['category_id']     ?? null,
            'brand_id'        => $validated['brand_id']        ?? null,
            'price'           => $validated['price'],
            'cost_price'      => $validated['cost_price']      ?? null,
            'stock'           => $validated['stock'],
            'low_stock_alert' => $validated['low_stock_alert'] ?? 5,
            'is_active'       => $request->boolean('is_active', true),
            'description'     => $validated['description']     ?? null,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Product \"{$product->name}\" updated!",
                'product' => $this->_formatProduct($product->load(['category','brand'])),
            ]);
        }

        return redirect()
            ->route('products.index')
            ->with('success', "Product \"{$product->name}\" updated!");
    }

    // -----------------------------------------------
    // DELETE /products/{product}
    // -----------------------------------------------
    public function destroy(Product $product): mixed
    {
        abort_if($product->shop_id !== auth()->user()->active_shop_id, 403);

        $name = $product->name;
        $product->update(['is_active' => false]);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Product \"{$name}\" deactivated.",
            ]);
        }

        return redirect()
            ->route('products.index')
            ->with('success', "Product \"{$name}\" deactivated.");
    }

    // -----------------------------------------------
    // GET /api/categories
    // -----------------------------------------------
    public function categories(Request $request): JsonResponse
    {
        $shopId     = auth()->user()->active_shop_id;
        $categories = Category::where('shop_id', $shopId)
            ->active()
            ->ofType('accessories')
            ->ordered()
            ->get(['id', 'name', 'slug']);

        return response()->json($categories);
    }

    // -----------------------------------------------
    // GET /api/brands
    // -----------------------------------------------
    public function brands(Request $request): JsonResponse
{
    $shopId = auth()->user()->active_shop_id;

    $query = Brand::where('shop_id', $shopId)->active()->ordered();

    // If category_id is provided, only return brands that have
    // products in that category
    if ($request->filled('category_id')) {
        $categoryId = $request->category_id;
        $query->whereHas('products', fn($q) =>
            $q->where('shop_id', $shopId)
              ->where('category_id', $categoryId)
              ->where('is_active', true)
        );
    }

    return response()->json(
        $query->get(['id', 'name', 'slug'])
    );
}

    // -----------------------------------------------
    // GET /products/report?type=all|low_stock|out_of_stock
    // Printable HTML report — no layout wrapper
    // -----------------------------------------------
    public function report(Request $request)
    {
        $shopId = auth()->user()->active_shop_id;
        $type   = $request->input('type', 'all');

        $query = Product::where('shop_id', $shopId)
            ->with(['category', 'brand'])
            ->where('is_active', true)
            ->orderBy('name');

        $title = match($type) {
            'low_stock'     => 'Low Stock Report',
            'out_of_stock'  => 'Out of Stock Report',
            'value'         => 'Stock Value Report',
            default         => 'All Products Report',
        };

        if ($type === 'low_stock') {
            $query->whereColumn('stock', '<=', 'low_stock_alert')->where('stock', '>', 0);
        } elseif ($type === 'out_of_stock') {
            $query->where('stock', '<=', 0);
        }

        $products   = $query->get();
        $shopName   = auth()->user()->activeShop?->name ?? 'Shop';
        $currency   = auth()->user()->activeShop?->currency_symbol ?? '£';
        $totalValue = $products->sum(fn($p) => $p->stock * ($p->cost_price ?? 0));
        $totalSell  = $products->sum(fn($p) => $p->stock * ($p->sell_price ?? 0));
        $date       = now()->format('d/m/Y H:i');

        return view('products.report', compact(
            'products', 'title', 'shopName', 'currency',
            'totalValue', 'totalSell', 'date', 'type'
        ));
    }

    // -----------------------------------------------
    // Private — Format product for JSON
    // -----------------------------------------------
    private function _formatProduct(Product $product): array
    {
        return [
            'id'              => $product->id,
            'name'            => $product->name,
            'sku'             => $product->sku,
            'category'        => $product->category?->name,
            'category_id'     => $product->category_id,
            'brand'           => $product->brand?->name,
            'brand_id'        => $product->brand_id,
            'price'           => (float) $product->sell_price,
            'cost_price'      => (float) $product->cost_price,
            'stock'           => (int) $product->stock,
            'low_stock_alert' => (int) $product->low_stock_alert,
            'is_active'       => (bool) $product->is_active,
            'formatted_price' => '£' . number_format($product->sell_price, 2),
        ];
    }
}