<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class SetActiveShop
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Super admin gets all shops
            if ($user->isSuperAdmin()) {
                $shops = \App\Models\Shop::where('is_active', true)->get();
            } else {
                $shops = $user->activeShops()->get();
            }

            // Auto-set active shop if not set
            if (!$user->hasActiveShop() && $shops->isNotEmpty()) {
                $user->update(['active_shop_id' => $shops->first()->id]);
                $user->refresh();
            }

            // Get current active shop
            $activeShop = $user->getCurrentShop();

            // Share with all views
            View::share('activeShop', $activeShop);
            View::share('userShops', $shops);

            // Store in app container for easy access
            app()->instance('activeShop', $activeShop);
        }

        return $next($request);
    }
}