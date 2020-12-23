<?php


namespace App\Payments\Gateways;


use App\Payments\Gateway;
use App\User;
use Stripe\Customer as StripeCustomer;

class StripeGateWay implements Gateway
{
    protected $user;

    public function WithUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function createCustomer()
    {
        if ($this->user->gateway_customer_id) {
            return $this->getCustomer() ;
        }
        $customer = new StripeGatewayCustomer($this, $this->createStripeCustomer());

        $this->user->update([
            'gateway_customer_id' => $customer->id()
        ]);
        return $customer;
    }

    public function getCustomer(){
        return new StripeGatewayCustomer($this, StripeCustomer::retrieve($this->user->gateway_customer_id));
    }

    protected function createStripeCustomer()
    {
        return StripeCustomer::create([
            'email' => $this->user->email
        ]);
    }

    public function user()
    {
        return $this->user;
    }
}