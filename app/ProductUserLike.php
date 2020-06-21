<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductUserLike extends Model
{
    protected $table = 'product_user_like';

    protected $fillable = ['user_id'];

    public function rProduct()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
