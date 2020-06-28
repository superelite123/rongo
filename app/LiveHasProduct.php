<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiveHasProduct extends Model
{
    //
    protected $table = 'live_has_product';

    public function getSoldStatusAttribute()
    {
        return $this->qty - $this->sold_qty <=0 ? 1 : 0;
    }

    public function rProduct()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function rLive()
    {
        return $this->belongsTo(Live::class,'live_id');
    }
}
