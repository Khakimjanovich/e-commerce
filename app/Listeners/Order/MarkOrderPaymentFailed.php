<?php


namespace App\Listeners\Order;


use App\Models\API\Order;

class MarkOrderPaymentFailed
{
    /**
     * @param $event
     */
    public function handle($event)
    {
        $event->order->update([
            'status' => Order::PAYMENT_FAILED
        ]);
    }
}