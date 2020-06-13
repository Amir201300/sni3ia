<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    public function winch()
    {
        return $this->belongsTo(User::class,'winch_id');
    }
}
