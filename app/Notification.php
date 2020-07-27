<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    public function rStore()
    {
        return $this->belongsTo(Store::class,'store_id');
    }

    public function rUser()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function rProduct()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function rOrder()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function rLive()
    {
        return $this->belongsTo(Live::class,'live_id');
    }
}
