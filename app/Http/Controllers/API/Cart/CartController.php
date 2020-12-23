<?php

namespace App\Http\Controllers\API\Cart;

use App\Cart\Cart;
use App\Http\Controllers\API\ResponseController;
use App\Http\Resources\API\Cart\UserCartResource;
use App\Models\API\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends ResponseController
{
    public function index(Request $request, Cart $cart)
    {
        $request->user()->load(['cart.product', 'cart.product.variations.stock', 'cart.stock']);
        //sync is syncs cart to stock
//        $cart->sync();
        return (new UserCartResource($request->user()))
            ->additional([
                    'meta' => $this->meta($cart,$request)
            ]);
    }

    protected function meta(Cart $cart,Request $request){
        return [
            'empty' => $cart->isEmpty(),
            'subtotal' => $cart->subtotal()->formatted(),
            'total' => $cart->withShipping($request->shipping_method_id)->total()->formatted(),
            'changed' => $cart->hasChanged(),
        ];
    }

    public function store(Request $request, Cart $cart)
    {
        $validator = Validator::make($request->all(), [
            'products' => 'required|array',
            'products.*.id' => 'required|exists:product_variations,id',
            'products.*.quantity' => 'min:1'
        ]);
        if ($validator->fails()) {
            $message['error'] = $validator->errors();
            return $this->error($message);
        }

        $cart->add($request->products);

    }

    public function update(ProductVariation $productVariation, Request $request, Cart $cart)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            $message['error'] = $validator->errors();
            return $this->error($message);
        }
        $cart->update($productVariation->id, $request->quantity);
    }


    public function destroy(ProductVariation $productVariation, Cart $cart)
    {

        $cart->delete($productVariation->id);
    }


}
