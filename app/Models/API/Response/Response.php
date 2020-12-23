<?php

namespace App\Models\API;

use App\Models\API\Response\Message;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
