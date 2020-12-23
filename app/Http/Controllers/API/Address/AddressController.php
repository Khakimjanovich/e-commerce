<?php

namespace App\Http\Controllers\API\Address;

use App\Http\Controllers\API\ResponseController;
use App\Http\Resources\API\Adress\AddressResource;
use App\Models\API\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends ResponseController
{
    public function index(Request $request)
    {
        $message['result'] = AddressResource::collection($request->user()->address);
        return $this->response($message);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'address_1' => 'required',
            'district' => 'required',
            'region_id' => 'required'
        ]);
        if ($validator->fails()){
            $message['error'] = $validator->errors();
            return $this->error($message);
        }
        $address = Address::make($request->only(['address_1','district','region_id','default']));
        $request->user()->address()->save($address);

        $message['result'] = new AddressResource($address);
        return $this->response($message);
    }

    public function show(Address $address)
    {
        $message['result'] = new AddressResource($address);
        return $this->response($message);
    }
}
