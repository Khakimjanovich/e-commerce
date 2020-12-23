<?php

namespace App\Http\Middleware\Cart;

use App\Cart\Cart;
use Closure;

class Sync
{
    protected $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }
    public function handle($request, Closure $next)
    {
        $this->cart->sync();
        if($this->cart->hasChanged()){
            return response()->json([
               'message' => 'Items in your cart have changed, Please review the changes'
            ],409);
        }
        return $next($request);
    }
}
