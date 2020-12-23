<?php

namespace App\Http\Resources\API\Order;

use App\Http\Resources\API\Adress\AddressResource;
use App\Http\Resources\API\Products\ProductVariationResource;
use App\Http\Resources\API\Shipping\ShippingMethodResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'subtotal' => $this->subtotal->formatted(),
//            'total' => $this->total,
            'products' => ProductVariationResource::collection(
                $this->whenLoaded('products')
            ),
            'address' => new AddressResource(
                $this->whenLoaded('address')
            ),
            'shipping_method' => new ShippingMethodResource(
                $this->whenLoaded('shipping')
            )
        ];
    }
}
