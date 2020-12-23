<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class ResponseController extends Controller
{
    public function response($message,$status = 200)
    {

        return response()->json([
            'status' => true,
            'result' => $message['result'],
        ],$status);
    }


    public function error($message,$status = 200)
    {

        return response()->json([
            'status' =>false,
            'error' => $message['error'],
        ],$status);
    }
}
