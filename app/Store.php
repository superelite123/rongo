<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;
use DB;
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

    public function rBackground()
    {
        return $this->hasMany(StoreBackground::class,'store_id');
    }

    public function rLiveStreams()
    {
        return $this->hasMany(Live::class,'store_id');
    }

    public function rEvaluation()
    {
        return $this->hasMany(StoreEvaluation::class,'store_id');
    }

    public function rExplantion()
    {
        return $this->hasMany(StoreExplantion::class,'store_id');
    }

    public function rProduct() {
        return $this->hasMany(Product::class,'store_id');
    }

    public function rTag()
    {
        return $this->hasMany(StoreHasTag::class,'store_id');
    }

    public function rEvaluationByType($type)
    {
        return $this->rEvaluation()->where('type',$type)->get();
    }

    public function getnTotalFollowAttribute()
    {
        return $this->rUsersFollow()->where('type',1)->get()->count();
    }

    public function getBackgroundAttribute()
    {
        $background = $this->rBackground()->first();
        if($background != null)
        return asset(Storage::url('StoreBackground').'/'.$background->filename);
        return null;
    }

    public function getEvaluationAttribute()
    {
        $data = $this->rEvaluation()
                    ->select('type', DB::raw('count(*) as total'))
                    ->groupBy('type')->get();

        return $data;
    }

    public function getExplantionsAttribute()
    {
        $explantions = $this->rExplantion()->orderBy('order')->get();
        $response = [];
        foreach($explantions as $explantion)
        {
            if(file_exists(Storage::url('StorageExplantion')))
            {
                $response[] = asset(Storage::url('StorageExplantion'));
            }
        }

        return $response;
    }

    public function getLiveStreams($status) {
        return $this->rLiveStreams()->whereIn('status_id', $status)->get();
    }
}
