<?php

namespace App\Http\Resources\API\Categories;

use App\Http\Resources\API\Products\ProductIndexResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryWithProductsResource extends JsonResource
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
            'name' =>$this->name,
            'products' => $this->products,
        ];
    }
}
