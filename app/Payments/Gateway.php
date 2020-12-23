<?php


namespace App\Payments;


use App\User;

interface Gateway
{
    public function WithUser(User $user);

    public function createCustomer();


}