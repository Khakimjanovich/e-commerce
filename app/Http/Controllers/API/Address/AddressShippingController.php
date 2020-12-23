<?php

namespace App\Http\Controllers\API\Address;

use App\Http\Controllers\API\ResponseController;
use App\Http\Resources\API\Shipping\ShippingMethodResource;
use App\Models\API\Address;

class AddressShippingController extends ResponseController
{
    public function action(Address $address)
    {
        $this->authorize('show',$address);
        $message['result'] = ShippingMethodResource::collection($address->region->shipping);

        return $this->response($message);
    }
}
