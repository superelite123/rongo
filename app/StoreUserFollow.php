<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreUserFollow extends Model
{
    //
    protected $table = 'store_user_follow';
    protected $fillable = ['store_id','type'];
    public function rUser()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function rStore()
    {
        return $this->belongsTo(Store::class,'store_id');
    }
}
