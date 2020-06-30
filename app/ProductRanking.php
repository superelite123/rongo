<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductRanking extends Model
{
    //
    protected $table = 'product_ranking';
    protected $fillable = ['product_id','order'];

    public function rProduct()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
