<?php

namespace App\Http\Resources\API\Products;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductIndexResource extends JsonResource
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
            'name' => $this->name,
            'excerpt' => $this->excerpt,
            'price' => $this->formattedPrice,
            'stock_count' => $this->stockCount(),
            'in_stock' => $this->inStock(),
        ];
    }
}
