<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductUserClick extends Model
{
    protected $table = 'product_user_like';

    protected $fillable = ['user_id','product_id'];

    public function rProduct()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
