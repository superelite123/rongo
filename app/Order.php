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

    public function rProduct() {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function rUser() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
