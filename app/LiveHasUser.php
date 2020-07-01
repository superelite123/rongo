<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiveHasUser extends Model
{
    //
    protected $table = 'live_has_user';

    public function rLive()
    {
        return $this->belongsTo(Live::class,'live_id');
    }
}
