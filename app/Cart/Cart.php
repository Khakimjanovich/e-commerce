<?php


namespace App\Cart;


use App\Models\API\ShippingMethod;
use App\User;

class Cart
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function products()
    {
        return $this->user->cart;
    }

    public function add($products)
    {

        $this->user->cart()->syncWithoutDetaching($this->getStorePayload($products));
    }

    protected function getStorePayload($products)
    {
        return
            collect($products)->keyBy('id')->map(function ($products) {
                return [
                    'quantity' => $products['quantity'] + $this->getCurrentQuantity($products['id'])
                ];
            })->toArray();
    }

    protected function getCurrentQuantity($productId)
    {
        if ($product = $this->user->cart->where('id', $productId)->first()) {
            return $product->pivot->quantity;
        }
        return 0;
    }

    public function update($productId, $quantity)
    {
           $this->user->cart()->updateExistingPivot($productId, [
            'quantity' => $quantity
        ]);
    }

    

    public function delete($productId)
    {
        $this->user->cart()->detach($productId);
    }

    public function empty()
    {
        $this->user->cart()->detach();
    }

    public function sync()
    {
        $this->user->cart->each(function ($product) {
            $quantity = $product->minStock($product->pivot->quantity);

            if ($quantity != $product->pivot->quantity){
                $this->changed = true;
            }

            $product->pivot->update([
                'quantity' => $quantity
            ]);
        });
    }

    public function isEmpty()
    {
        return $this->user->cart->sum('pivot.quantity') <= 0;
    }

    public function total()
    {
        if ($this->shipping){
            return $this->subtotal()->add($this->shipping->price);
        }

        return $this->subtotal();
    }

    public function subtotal()
    {
        $subtotal = $this->user->cart->sum(function ($product){
            return $product->price->amount()*$product->pivot->quantity;
        });

        return new Money($subtotal);
    }

    protected $changed = false;

    public function hasChanged()
    {
        return $this->changed;
    }

    protected $shipping;
    public function withShipping($shippingId)
    {
        $this->shipping = ShippingMethod::find($shippingId);
        return $this;
    }


}