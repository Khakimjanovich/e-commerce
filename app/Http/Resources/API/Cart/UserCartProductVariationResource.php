<?php

namespace App\Http\Resources\API\Cart;

use App\Cart\Money;
use App\Http\Resources\API\Products\ProductIndexResource;
use App\Http\Resources\API\Products\ProductVariationResource;
use Illuminate\Http\Request;

class UserCartProductVariationResource extends ProductVariationResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $total = new Money($this->pivot->quantity*$this->price->amount());
        return array_merge(parent::toArray($request),[
            'product' => new ProductIndexResource($this->product),
            'quantity' => $this->pivot->quantity,
            'total' => $total->formatted()
        ]);
    }
}
