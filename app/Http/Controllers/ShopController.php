<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    // -----------------------------------------------
    // Show shop selection page
    // -----------------------------------------------
    public function select()
    {
        $user  = Auth::user();
        $shops = $user->isSuperAdmin()
            ? Shop::where('is_active', true)->get()
            : $user->activeShops()->get();

        // If only one shop — auto select and redirect
        if ($shops->count() === 1) {
            $this->switchShop($shops->first()->id);
            return redirect()->route('dashboard');
        }

        return view('shops.select', compact('shops'));
    }

    // -----------------------------------------------
    // Switch active shop
    // -----------------------------------------------
    public function switch(Request $request)
    {
        $request->validate([
            'shop_id' => ['required', 'exists:shops,id'],
        ]);

        $user   = Auth::user();
        $shopId = $request->shop_id;

        // Verify user has access to this shop
        if (!$user->isSuperAdmin()) {
            $hasAccess = $user->activeShops()
                              ->where('shop_id', $shopId)
                              ->exists();

            if (!$hasAccess) {
                abort(403, 'You do not have access to this shop.');
            }
        }

        $this->switchShop($shopId);

        return redirect()->intended(route('dashboard'))
                         ->with('success', 'Shop switched successfully!');
    }

    // -----------------------------------------------
    // Super Admin — Create shop
    // -----------------------------------------------
    public function create()
    {
        return view('shops.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'phone'           => ['nullable', 'string', 'max:20'],
            'email'           => ['nullable', 'email', 'max:255'],
            'address'         => ['nullable', 'string'],
            'city'            => ['nullable', 'string', 'max:100'],
            'currency'        => ['nullable', 'string', 'max:10'],
            'currency_symbol' => ['nullable', 'string', 'max:5'],
        ]);

        $shop = Shop::create($request->all());

        return redirect()->route('shops.index')
                         ->with('success', "Shop '{$shop->name}' created successfully!");
    }

    // -----------------------------------------------
    // Super Admin — List all shops
    // -----------------------------------------------
    public function index()
    {
        $shops = Shop::withCount('users')
                     ->latest()
                     ->paginate(15);

        return view('shops.index', compact('shops'));
    }

    // -----------------------------------------------
    // Super Admin — Assign user to shop
    // -----------------------------------------------
    public function assignUser(Request $request, Shop $shop)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'role'    => ['nullable', 'string'],
        ]);

        $shop->users()->syncWithoutDetaching([
            $request->user_id => [
                'role'      => $request->role,
                'is_active' => true,
            ]
        ]);

        return back()->with('success', 'User assigned to shop successfully!');
    }

    // -----------------------------------------------
    // Private helper
    // -----------------------------------------------
    private function switchShop(int $shopId): void
    {
        Auth::user()->update(['active_shop_id' => $shopId]);
    }
}