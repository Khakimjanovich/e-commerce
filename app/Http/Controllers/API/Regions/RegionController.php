<?php

namespace App\Http\Controllers\API\Regions;

use App\Http\Controllers\API\ResponseController;
use App\Http\Resources\API\Region\RegionResource;
use App\Models\API\Region;

class RegionController extends ResponseController
{
    public function index()
    {
        $message['result'] = RegionResource::collection(Region::get());
        return $this->response($message);
    }
}
