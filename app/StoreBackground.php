<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreBackground extends Model
{
    //
    protected $table = 'store_background';
    protected $fillable = ['filename','order'];
}
