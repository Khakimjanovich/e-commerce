<?php

namespace App\Models\API;

use App\Models\Traits\CanBeDefault;
use App\User;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use CanBeDefault;

    protected $fillable = [
        'card_type',
        'last_four',
        'provider_id',
        'default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
