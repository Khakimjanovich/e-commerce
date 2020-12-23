<?php


namespace App\Listeners\Order;


use App\Models\API\Order;

class MarkOrderProcessing
{
    /**
     * @param $event
     */
    public function handle($event)
    {
        $event->order->update([
            'status' => Order::PROCESSING
        ]);
    }
}