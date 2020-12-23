<?php

namespace App\Rules;

use App\Models\API\Address;
use Illuminate\Contracts\Validation\Rule;

class ValidShippingMethod implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $address;
    public function __construct($addressId)
    {
        $address = Address::find($addressId);
        $this->address = $address;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!$this->address){
            return false;
        }
        return $this->address->region->shipping->contains('id',$value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid shipping method.';
    }
}
