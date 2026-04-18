<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    // -----------------------------------------------
    // GET /shops
    // -----------------------------------------------
    public function index()
    {
        $shops = Shop::withCount('users')->latest()->paginate(15);
        return view('shops.index', compact('shops'));
    }

    // -----------------------------------------------
    // GET /shops/create
    // -----------------------------------------------
    public function create()
    {
        return view('shops.create');
    }

    // -----------------------------------------------
    // POST /shops
    // -----------------------------------------------
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'phone'           => ['nullable', 'string', 'max:30'],
            'email'           => ['nullable', 'email', 'max:255'],
            'address'         => ['nullable', 'string', 'max:500'],
            'city'            => ['nullable', 'string', 'max:100'],
            'country'         => ['nullable', 'string', 'max:100'],
            'currency'        => ['nullable', 'string', 'max:10'],
            'currency_symbol' => ['nullable', 'string', 'max:5'],
            'timezone'        => ['nullable', 'string', 'max:50'],
            'is_active'       => ['nullable'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $shop = Shop::create($validated);

        return redirect()->route('shops.index')
                         ->with('success', "Shop '{$shop->name}' created successfully!");
    }

    // -----------------------------------------------
    // GET /shops/{shop}
    // -----------------------------------------------
    public function show(Shop $shop)
    {
        $shop->load('users');
        $allUsers = User::orderBy('name')->get();
        return view('shops.show', compact('shop', 'allUsers'));
    }

    // -----------------------------------------------
    // GET /shops/{shop}/edit
    // -----------------------------------------------
    public function edit(Shop $shop)
    {
        return view('shops.edit', compact('shop'));
    }

    // -----------------------------------------------
    // PUT /shops/{shop}
    // -----------------------------------------------
    public function update(Request $request, Shop $shop)
    {
        $validated = $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'phone'           => ['nullable', 'string', 'max:30'],
            'email'           => ['nullable', 'email', 'max:255'],
            'address'         => ['nullable', 'string', 'max:500'],
            'city'            => ['nullable', 'string', 'max:100'],
            'country'         => ['nullable', 'string', 'max:100'],
            'currency'        => ['nullable', 'string', 'max:10'],
            'currency_symbol' => ['nullable', 'string', 'max:5'],
            'timezone'        => ['nullable', 'string', 'max:50'],
            'is_active'       => ['nullable'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $shop->update($validated);

        return redirect()->route('shops.show', $shop)
                         ->with('success', "Shop '{$shop->name}' updated successfully!");
    }

    // -----------------------------------------------
    // DELETE /shops/{shop}
    // -----------------------------------------------
    public function destroy(Shop $shop)
    {
        $name = $shop->name;
        $shop->delete();

        return redirect()->route('shops.index')
                         ->with('success', "Shop '{$name}' deleted.");
    }

    // -----------------------------------------------
    // POST /shops/{shop}/assign-user
    // -----------------------------------------------
    public function assignUser(Request $request, Shop $shop)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'role'    => ['nullable', 'string', 'in:staff,shop_admin'],
        ]);

        $shop->users()->syncWithoutDetaching([
            $request->user_id => [
                'role'      => $request->role ?? 'staff',
                'is_active' => true,
            ],
        ]);

        return back()->with('success', 'User assigned to shop.');
    }

    // -----------------------------------------------
    // DELETE /shops/{shop}/users/{user}
    // -----------------------------------------------
    public function removeUser(Shop $shop, User $user)
    {
        $shop->users()->detach($user->id);
        return back()->with('success', "{$user->name} removed from shop.");
    }

    // -----------------------------------------------
    // Shop Selection (login flow)
    // -----------------------------------------------
    public function select()
    {
        $user  = Auth::user();
        $shops = $user->isSuperAdmin()
            ? Shop::where('is_active', true)->get()
            : $user->activeShops()->get();

        if ($shops->count() === 1) {
            Auth::user()->update(['active_shop_id' => $shops->first()->id]);
            return redirect()->route('dashboard');
        }

        return view('shops.select', compact('shops'));
    }

    // -----------------------------------------------
    // POST /shop/switch
    // -----------------------------------------------
    public function switch(Request $request)
    {
        $request->validate(['shop_id' => ['required', 'exists:shops,id']]);

        $user   = Auth::user();
        $shopId = $request->shop_id;

        if (!$user->isSuperAdmin()) {
            $hasAccess = $user->activeShops()->where('shop_id', $shopId)->exists();
            if (!$hasAccess) abort(403);
        }

        $user->update(['active_shop_id' => $shopId]);

        return redirect()->intended(route('dashboard'))->with('success', 'Shop switched!');
    }
}