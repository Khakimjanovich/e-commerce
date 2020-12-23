<?php

namespace App\Listeners\Order;

use App\Cart\Cart;
use App\Events\Order\OrderCreated;

class EmptyCard
{

    protected $cart;

    /**
     * EmptyCard constructor.
     * @param Cart $cart
     */
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * @param OrderCreated $event
     */
    public function handle()
    {
        $this->cart->empty();
    }
}
