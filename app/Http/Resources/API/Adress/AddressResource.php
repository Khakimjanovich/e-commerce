<?php

namespace App\Http\Resources\API\Adress;

use App\Http\Resources\API\Region\RegionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'address' => $this->address_1,
            'district' => $this->district,
            'default' => $this->default,
            'region' => new RegionResource($this->region)
        ];
    }
}
