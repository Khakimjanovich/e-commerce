<?php

namespace App\Models\API;

use App\Models\Traits\HasPrice;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use HasPrice;

    public function region()
    {
        return $this->belongsToMany(Region::class);
    }
}
