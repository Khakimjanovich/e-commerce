<?php

namespace App\Models;

use App\Models\API\Response\Message;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
