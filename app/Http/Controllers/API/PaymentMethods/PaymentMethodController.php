<?php

namespace App\Http\Controllers\API\PaymentMethods;

use App\Http\Controllers\API\ResponseController;
use App\Http\Resources\API\PaymentMethodResource;
use App\Payments\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;

class PaymentMethodController extends ResponseController
{

    public $gateway;
    private $stripe_key = "sk_test_uXhI2e7BY5NGtORa2uUd0mlN00QErVhUZ1";
    public function __construct(Gateway $gateway)
    {
        $this->gateway = $gateway;
        Stripe::setApiKey($this->stripe_key);
    }

    public function index(Request $request)
    {
        $message['result'] = PaymentMethodResource::collection($request->user()->paymentMethods);
        return $this->response($message);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'token' => 'required'
        ]);
        if ($validator->fails()){
            $message['error'] = $validator->errors();
            return $this->error($message);
        }

        $card = $this->gateway->withUser($request->user())
            ->createCustomer()
            ->addCard($request->token);

        $message['result'] = new PaymentMethodResource($card);
        return $this->response($message);
    }
}
