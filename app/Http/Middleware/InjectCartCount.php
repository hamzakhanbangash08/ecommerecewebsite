<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class InjectCartCount
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
        } else {
            $cart = session()->get('cart', []);
            $cartCount = collect($cart)->sum('quantity');
        }

        View::share('cartCount', $cartCount);

        return $next($request);
    }
}
