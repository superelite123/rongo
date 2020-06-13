<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Live extends Model
{
    //
    public function rStatus()
    {
        return $this->hasOne(Status::class,'status_id');
    }

    public function rTag()
    {
        return $this->belongsTo(Tag::class,'tag_id');
    }

    public function rStore()
    {
        return $this->belongsTo(Store::class,'store_id');
    }

    public function rUsers()
    {
        return $this->hasMany(LiveHasUser::class,'live_id');
    }

    public function rEvaluation()
    {
        return $this->hasMany(LiveEvaluation::class,'live_id');
    }

    public function getnTotalUsersAttribute()
    {
        return $this->rUsers()->count();
    }
}
