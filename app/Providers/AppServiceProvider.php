<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Compatibility for older MySQL/MariaDB index length limits.
        Schema::defaultStringLength(191);

        // Share cart item count (sum of quantities) to navbar across shop pages.
        View::composer('layouts.app', function ($view) {
            $sessionId = session('cart_session_id');

            if (!$sessionId) {
                $sessionId = session()->getId();
                session(['cart_session_id' => $sessionId]);
            }

            $cartCount = Cart::where('session_id', $sessionId)->sum('quantity');
            $view->with('navCartCount', $cartCount);
        });
    }
}
