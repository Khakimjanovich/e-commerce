<?php

namespace App\Policies\API;

use App\Models\API\Address;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AddressPolicy
{
    use HandlesAuthorization;

    public function show(User $user, Address $address)
    {
        return $user->id == $address->user_id;
    }
}
