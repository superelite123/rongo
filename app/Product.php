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

    public function rOrder()
    {
        return $this->hasMany(Order::class,'product_id');
    }

    public function Thumbnail()
    {
        $thumanail = $this->rPortfolio()->where('order','=', 1)->first();
        if($thumanail != null)
        {
            return $thumanail->filename;
        }
        else
        {
            $thumanail = $this->rPortfolio()->first();
            return $thumanail != null?$thumanail->filename:'default.png';
        }
    }

    public function rStore()
    {
        return $this->belongsTo(Store::class,'store_id');
    }

    public function rShipper()
    {
        return $this->belongsTo(Shipper::class,'shipper_id');
    }

    public function getTotalPriceAttribute()
    {
        return $this->price + $this->shipping_fee;
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
        $res = $this->rUserLike()->where('user_id',auth()->user()->id)->get();
        return $res->isNotEmpty()?1:0;
    }
}
