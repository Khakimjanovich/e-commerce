<?php

namespace App\Http\Resources\API\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserPrivateInfoResource extends JsonResource
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
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->hasEmail(),
            'email_verified' => $this->hasVerifiedEmail(),
        ];
    }
}
