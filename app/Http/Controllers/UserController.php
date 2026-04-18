<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    // -----------------------------------------------
    // GET /users
    // -----------------------------------------------
    public function index()
    {
        $users = User::with('shops')->orderBy('name')->paginate(20);
        return view('users.index', compact('users'));
    }

    // -----------------------------------------------
    // GET /users/create
    // -----------------------------------------------
    public function create()
    {
        $shops = Shop::where('is_active', true)->orderBy('name')->get();
        return view('users.create', compact('shops'));
    }

    // -----------------------------------------------
    // POST /users
    // -----------------------------------------------
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::min(8)],
            'role'     => ['required', 'string', 'in:staff,shop_admin,super_admin'],
            'shop_id'  => ['nullable', 'exists:shops,id'],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Assign role (Spatie)
        $user->assignRole($validated['role']);

        // Assign to shop if selected
        if (!empty($validated['shop_id'])) {
            $user->shops()->attach($validated['shop_id'], [
                'role'      => $validated['role'] === 'super_admin' ? 'shop_admin' : $validated['role'],
                'is_active' => true,
            ]);
            $user->update(['active_shop_id' => $validated['shop_id']]);
        }

        return redirect()->route('users.index')
                         ->with('success', "User '{$user->name}' created successfully!");
    }

    // -----------------------------------------------
    // GET /users/{user}/edit
    // -----------------------------------------------
    public function edit(User $user)
    {
        $user->load('shops');
        $shops = Shop::where('is_active', true)->orderBy('name')->get();
        return view('users.edit', compact('user', 'shops'));
    }

    // -----------------------------------------------
    // PUT /users/{user}
    // -----------------------------------------------
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::min(8)],
            'role'     => ['required', 'string', 'in:staff,shop_admin,super_admin'],
            'shop_ids' => ['nullable', 'array'],
            'shop_ids.*'=> ['exists:shops,id'],
        ]);

        $user->update([
            'name'  => $validated['name'],
            'email' => $validated['email'],
            ...(!empty($validated['password']) ? ['password' => Hash::make($validated['password'])] : []),
        ]);

        // Update role
        $user->syncRoles([$validated['role']]);

        // Sync shops
        $shopIds = $validated['shop_ids'] ?? [];
        $pivotData = collect($shopIds)->mapWithKeys(fn($id) => [
            $id => [
                'role'      => $validated['role'] === 'super_admin' ? 'shop_admin' : $validated['role'],
                'is_active' => true,
            ]
        ])->toArray();
        $user->shops()->sync($pivotData);

        // Update active_shop_id if current shop was removed
        if ($user->active_shop_id && !in_array($user->active_shop_id, $shopIds)) {
            $user->update(['active_shop_id' => collect($shopIds)->first()]);
        }

        return redirect()->route('users.index')
                         ->with('success', "User '{$user->name}' updated successfully!");
    }

    // -----------------------------------------------
    // DELETE /users/{user}
    // -----------------------------------------------
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'You cannot delete your own account.']);
        }

        $name = $user->name;
        $user->shops()->detach();
        $user->delete();

        return redirect()->route('users.index')->with('success', "User '{$name}' deleted.");
    }
}