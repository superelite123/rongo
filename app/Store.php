<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    //
    public function rUsersFollow()
    {
        return $this->hasMany(StoreUserFollow::class,'store_id');
    }

    public function rUser()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function rPortfolio()
    {
        return $this->hasMany(StorePortfolio::class,'store_id');
    }

    public function getnTotalFollowAttribute()
    {
        return $this->rUsersFollow()->where('type',1)->count();
    }

    public function getnTotalFollowsAttribute()
    {
        return $this->rUsersFollow()->count();
    }

    public function rThumbnail()
    {
        return $this->belongsTo(StorePortfolio::class,'portfolio_id');
    }

    public function rEvaluation()
    {
        return $this->hasMany(StoreUserEvaluation::class,'store_id');
    }

    public function rEvaluationByType($type)
    {
        return $this->rEvaluation()->where('type',$type)->get();
    }
}
