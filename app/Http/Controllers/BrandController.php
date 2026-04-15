<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BrandController extends Controller
{
    // -----------------------------------------------
    // GET /brands
    // -----------------------------------------------
    public function index(Request $request)
    {
        $shopId = auth()->user()->active_shop_id;

        $query = Brand::forShop($shopId)
            ->withCount('products');

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $query->ordered();

        // AJAX — return JSON
        if ($request->ajax() || $request->filled('_ajax')) {
            $brands = $query->get()->map(fn($b) => $this->_format($b));

            return response()->json([
                'brands' => $brands,
                'total'  => $brands->count(),
            ]);
        }

        $brands = $query->paginate(50)->withQueryString();

        $stats = [
            'total'    => Brand::forShop($shopId)->count(),
            'active'   => Brand::forShop($shopId)->active()->count(),
            'inactive' => Brand::forShop($shopId)
                ->where('is_active', false)->count(),
        ];

        return view('brands.index', compact('brands', 'stats'));
    }

    // -----------------------------------------------
    // POST /brands
    // -----------------------------------------------
    public function store(Request $request): JsonResponse
    {
        $shopId = auth()->user()->active_shop_id;

        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:100'],
            'is_active'  => ['nullable'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $exists = Brand::forShop($shopId)
            ->where('name', $validated['name'])
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'errors'  => [
                    'name' => ['A brand with this name already exists.']
                ],
            ], 422);
        }

        $brand = Brand::create([
            'shop_id'    => $shopId,
            'name'       => $validated['name'],
            'is_active'  => filter_var(
                $request->input('is_active', true),
                FILTER_VALIDATE_BOOLEAN
            ),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => "Brand \"{$brand->name}\" created!",
            'brand'   => $this->_format($brand->loadCount('products')),
        ]);
    }

    // -----------------------------------------------
    // PUT /brands/{brand}
    // -----------------------------------------------
    public function update(
        Request $request,
        Brand   $brand
    ): JsonResponse {
        abort_if(
            $brand->shop_id !== auth()->user()->active_shop_id,
            403
        );

        $shopId = auth()->user()->active_shop_id;

        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:100'],
            'is_active'  => ['nullable'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $exists = Brand::forShop($shopId)
            ->where('name', $validated['name'])
            ->where('id', '!=', $brand->id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'errors'  => [
                    'name' => ['A brand with this name already exists.']
                ],
            ], 422);
        }

        $brand->update([
            'name'       => $validated['name'],
            'is_active'  => filter_var(
                $request->input('is_active', true),
                FILTER_VALIDATE_BOOLEAN
            ),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => "Brand \"{$brand->name}\" updated!",
            'brand'   => $this->_format($brand->loadCount('products')),
        ]);
    }

    // -----------------------------------------------
    // DELETE /brands/{brand}
    // -----------------------------------------------
    public function destroy(Brand $brand): JsonResponse
    {
        abort_if(
            $brand->shop_id !== auth()->user()->active_shop_id,
            403
        );

        if ($brand->products()->exists()) {
            return response()->json([
                'success' => false,
                'message' => "Cannot delete — {$brand->products()->count()} products use this brand.",
            ], 422);
        }

        $name = $brand->name;
        $brand->delete();

        return response()->json([
            'success' => true,
            'message' => "Brand \"{$name}\" deleted.",
        ]);
    }

    // -----------------------------------------------
    // Format for JSON
    // -----------------------------------------------
    private function _format(Brand $brand): array
    {
        return [
            'id'             => $brand->id,
            'name'           => $brand->name,
            'slug'           => $brand->slug,
            'is_active'      => (bool) $brand->is_active,
            'sort_order'     => (int) $brand->sort_order,
            'products_count' => (int) ($brand->products_count ?? 0),
        ];
    }
}