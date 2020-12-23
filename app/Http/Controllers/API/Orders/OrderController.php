<?php

namespace App\Http\Controllers\API\Orders;

use App\Cart\Cart;
use App\Events\Order\OrderCreated;
use App\Http\Controllers\API\ResponseController;
use App\Http\Resources\API\Order\OrderResource;
use App\Rules\ValidShippingMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OrderController extends ResponseController
{
    public function __construct()
    {
        $this->middleware(['cart.sync', 'cart.isnotempty'])->only('store');
    }

    public function index(Request $request)
    {
        $orders = $request->user()->orders()->with([
            'products',
            'products.stock',
            'products.type',
            'products.product',
            'products.product.variations',
            'products.product.variations.stock',
            'address',
            'shippingMethod'
        ])
            ->latest()
            ->get();
        $message['result'] = OrderResource::collection($orders);
        return $this->response($message);
    }

    public function store(Request $request, Cart $cart)
    {
        $validator = Validator::make($request->all(), [
            'address_id' => [
                'required',
                Rule::exists('addresses', 'id')->where(function ($builder) use ($request) {
                    $builder->where('user_id', $request->user()->id);
                }),

            ],
            'shipping_method_id' => [
                'required',
                'exists:shipping_methods,id',
                new ValidShippingMethod($request->address_id)
            ],
            'payment_method_id' => [
                'required',
                Rule::exists('payment_methods', 'id')->where(function ($builder) use ($request) {
                    $builder->where('user_id', $request->user()->id);
                }),
            ],
        ]);
        if ($validator->fails()) {
            $message['error'] = $validator->errors();
            return $this->error($message);
        }

        if ($cart->isEmpty()) {
            $message['error'] = 'Cart is empty';
            return $this->error($message, 400);
        }

        $order = $this->createOrder($request, $cart);


        $order->products()->sync($cart->products()->forSyncing());

        event(new OrderCreated($order));

        $message['result'] = new OrderResource($order);
        return $this->response($message);
    }

    protected function createOrder(Request $request, Cart $cart)
    {

        return $request->user()->orders()->create(
            array_merge($request->only(['address_id', 'shipping_method_id', 'payment_method_id']), [
                'subtotal' => $cart->subtotal()->amount()
            ])
        );
    }


}
