<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    // -----------------------------------------------
    // GET /categories
    // -----------------------------------------------
    public function index(Request $request)
    {
        $shopId = auth()->user()->active_shop_id;

        $query = Category::forShop($shopId)
            ->withCount('products');

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $query->ordered();

        // AJAX — return JSON
        if ($request->ajax() || $request->filled('_ajax')) {
            $categories = $query->get()->map(
                fn($c) => $this->_format($c)
            );

            return response()->json([
                'categories' => $categories,
                'total'      => $categories->count(),
            ]);
        }

        $categories = $query->paginate(50)->withQueryString();

        $stats = [
            'total'       => Category::forShop($shopId)->count(),
            'accessories' => Category::forShop($shopId)
                ->where('type', 'accessories')->count(),
            'repair'      => Category::forShop($shopId)
                ->where('type', 'repair')->count(),
            'both'        => Category::forShop($shopId)
                ->where('type', 'both')->count(),
        ];

        return view('categories.index', compact('categories', 'stats'));
    }

    // -----------------------------------------------
    // POST /categories
    // -----------------------------------------------
    public function store(Request $request): JsonResponse
    {
        $shopId = auth()->user()->active_shop_id;

        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:100'],
            'type'       => ['required', 'in:accessories,repair,both'],
            'is_active'  => ['nullable'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $exists = Category::forShop($shopId)
            ->where('name', $validated['name'])
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'errors'  => [
                    'name' => ['A category with this name already exists.']
                ],
            ], 422);
        }

        $category = Category::create([
            'shop_id'    => $shopId,
            'name'       => $validated['name'],
            'type'       => $validated['type'],
            'is_active'  => filter_var(
                $request->input('is_active', true),
                FILTER_VALIDATE_BOOLEAN
            ),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return response()->json([
            'success'  => true,
            'message'  => "Category \"{$category->name}\" created!",
            'category' => $this->_format(
                $category->loadCount('products')
            ),
        ]);
    }

    // -----------------------------------------------
    // PUT /categories/{category}
    // -----------------------------------------------
    public function update(
        Request  $request,
        Category $category
    ): JsonResponse {
        abort_if(
            $category->shop_id !== auth()->user()->active_shop_id,
            403
        );

        $shopId = auth()->user()->active_shop_id;

        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:100'],
            'type'       => ['required', 'in:accessories,repair,both'],
            'is_active'  => ['nullable'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $exists = Category::forShop($shopId)
            ->where('name', $validated['name'])
            ->where('id', '!=', $category->id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'errors'  => [
                    'name' => ['A category with this name already exists.']
                ],
            ], 422);
        }

        $category->update([
            'name'       => $validated['name'],
            'type'       => $validated['type'],
            'is_active'  => filter_var(
                $request->input('is_active', true),
                FILTER_VALIDATE_BOOLEAN
            ),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return response()->json([
            'success'  => true,
            'message'  => "Category \"{$category->name}\" updated!",
            'category' => $this->_format(
                $category->loadCount('products')
            ),
        ]);
    }

    // -----------------------------------------------
    // DELETE /categories/{category}
    // -----------------------------------------------
    public function destroy(Category $category): JsonResponse
    {
        abort_if(
            $category->shop_id !== auth()->user()->active_shop_id,
            403
        );

        if ($category->products()->exists()) {
            return response()->json([
                'success' => false,
                'message' => "Cannot delete — {$category->products()->count()} products use this category.",
            ], 422);
        }

        $name = $category->name;
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => "Category \"{$name}\" deleted.",
        ]);
    }

    // -----------------------------------------------
    // Format for JSON
    // -----------------------------------------------
    private function _format(Category $category): array
    {
        return [
            'id'             => $category->id,
            'name'           => $category->name,
            'slug'           => $category->slug,
            'type'           => $category->type,
            'type_label'     => $category->type_label,
            'is_active'      => (bool) $category->is_active,
            'sort_order'     => (int) $category->sort_order,
            'products_count' => (int) ($category->products_count ?? 0),
        ];
    }
}