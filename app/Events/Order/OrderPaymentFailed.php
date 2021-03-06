<?php

namespace App\Events\Order;

use App\Models\API\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderPaymentFailed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    /**
     * @var Order
     */
    public $order;

    /**
     * OrderPaymentFailed constructor.
     * @param Order $order
     */

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
