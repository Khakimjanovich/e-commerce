<?php

namespace App\Http\Resources\API\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [

            'products' => UserCartProductVariationResource::collection($this->cart),
        ];
    }
}
