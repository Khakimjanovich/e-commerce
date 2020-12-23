<?php


namespace App\Payments;


use App\Models\API\PaymentMethod;

interface GatewayCustomer
{
    public function charge(PaymentMethod $card,$amount);
    public function addCard($token);
    public function id();
}