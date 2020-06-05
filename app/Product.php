<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //

    public function rLive()
    {
        return $this->hasMany(LiveHasProduct::class,'product_id');
    }

    public function rAddedQty()
    {
        return $this->hasMany(ProductAddedQty::class,'product_id');
    }

    public function rTag()
    {
        return $this->hasMany(ProductHasTag::class,'product_id');
    }

    public function rUserLike()
    {
        return $this->hasMany(ProductUserLike::class,'user_id');
    }

    public function rPortfolio()
    {
        return $this->hasMany(ProductPortfolio::class,'product_id');
    }

    public function Thumbnail()
    {
        return $this->rPortfolio()->get
    }
}
