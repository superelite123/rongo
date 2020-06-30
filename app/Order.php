<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    public function rDAddress()
    {
        return $this->belongsTo(DAddress::class,'address_id');
    }
}
