<?php


namespace App\Listeners\Order;


use App\Events\Order\OrderCreated;
use App\Events\Order\OrderPaid;
use App\Events\Order\OrderPaymentFailed;
use App\Exceptions\PaymentFailedException;
use App\Payments\Gateway;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessPayment implements ShouldQueue
{
    protected $gateway;

    public function __construct(Gateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function handle(OrderCreated $event)
    {
        $order = $event->order;
        try {
            $this->gateway->WithUser($order->user)
                ->getCustomer()
                ->charge(
                    $order->paymentMethod, $order->total()->amount()
                );
            event(new OrderPaid($order));
        } catch (PaymentFailedException $e) {
            event(new OrderPaymentFailed($order));
        }
    }
}