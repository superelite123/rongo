<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserHasAddress extends Model
{
    //
    protected $table = 'user_has_address';

    public function rAddress()
    {
        return $this->belongsTo(Address::class,'address_id');
    }
}
