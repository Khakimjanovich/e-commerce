<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public $timestamps =false;
    protected $fillable =[
        'name',
        'code',
    ];

    public function shipping()
    {
        return $this->belongsToMany(ShippingMethod::class);
    }
}
