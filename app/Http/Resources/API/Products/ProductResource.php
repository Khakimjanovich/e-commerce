<?php

namespace App\Http\Resources\API\Products;

class ProductResource extends ProductIndexResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request),
            [
                'description' => $this->description,
                'variations' => ProductVariationResource::collection(
                    $this->variations->groupBy('type.name')
                ),
            ]);
    }
}
