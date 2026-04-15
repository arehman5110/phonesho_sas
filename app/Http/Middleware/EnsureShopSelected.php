<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureShopSelected
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Super admin always has access
            if ($user->isSuperAdmin()) {
                return $next($request);
            }

            // Check if user belongs to any shop
            $hasShops = $user->activeShops()->exists();

            if (!$hasShops) {
                Auth::logout();
                return redirect()->route('login')
                    ->withErrors(['email' => 'You are not assigned to any shop. Please contact your administrator.']);
            }

            // Check if user has an active shop set
            if (!$user->hasActiveShop()) {
                // If user only has one shop, auto select it
                $shops = $user->activeShops()->get();

                if ($shops->count() === 1) {
                    $user->update(['active_shop_id' => $shops->first()->id]);
                    return $next($request);
                }

                // If multiple shops, redirect to shop selection
                if ($request->routeIs('shop.select*')) {
                    return $next($request);
                }

                return redirect()->route('shop.select');
            }
        }

        return $next($request);
    }
}