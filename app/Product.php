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
        return $this->hasMany(ProductUserLike::class,'product_id');
    }

    public function rPortfolio()
    {
        return $this->hasMany(ProductPortfolio::class,'product_id');
    }

    public function Thumbnail()
    {
        return $this->rPortfolio()->where('order','=', 1);
    }

    public function rStore()
    {
        return $this->belongsTo(Store::class,'store_id');
    }

    public function getStoreInfoAttribute()
    {
        $data = [];
        //get Store Name
        $store = $this->rStore;
        if($store != null){

            $data['storeId'] = $store->id;
            $data['storeName'] = $store->rUser == null?null:$store->rUser->nickname;
            $data['nStoreFollow'] = $store->nTotalFollow;
            $data['storeThumbnail'] = $store->rUser->cIcon;

            $isFollow = auth()->user()->rStoreFollow()->where('store_id',$store->id)->first();
            $data['isFollow'] = $isFollow != null?1:0;
        }

        return $data;
    }

    public function getIsLikeAttribute(){
        $likeUsers = $this->rUserLike;
        foreach($likeUsers as $user)
        {
            return 1;
        }
        return 0;
    }
}
