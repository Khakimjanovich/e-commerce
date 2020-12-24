<?php

namespace App\Models;

use App\Models\Traits\CanBeDefault;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use CanBeDefault;

    protected $fillable =
        [
            'address_1',
            'district',
            'region_id',
            'default'
        ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function region()
    {
        return $this->hasOne(Region::class, 'id', 'region_id');
    }
}
