<?php
namespace App\Traits;

use Storage;
use DB;
use App\Product;
use App\Live;
use App\Store;
use App\Notification;
use App\News;
use App\Helper\CommonFunction;
use Config;
trait LoadList
{
    use CommonFunction;
    public function loadProducts($options)
    {
        $options['status'] = [];
        $options['status'][0] = Config::get('constants.pStatus.staged');
        $options['status'][1] = Config::get('constants.pStatus.restaged');
        $options['status'][2] = Config::get('constants.pStatus.sold');
        $cond = Product::whereIn('status_id',$options['status']);
        //specify the store
        if(isset($options['store_id']))
        {
            $cond = $cond->where('store_id',$options['store_id']);
        }
        //specify product keyword
        if(isset($options['keyword']))
        {
            $cond = $cond->where('label','like','%'.$options['keyword'].'%');
        }
        //if type == 2 favourite
        if(isset($options['type']))
        {
            if($options['type'] == 2)
            {
                $cond = $cond->whereHas('rUserLike',function ( $query ) {
                    $query->where('user_id', auth()->user()->id);
                });
            }
        }

        $products = $cond->get();
        $thumbnailRootUrl = asset(Storage::url('ProductPortfolio')).'/';
        $json = [];
        foreach($products as $product)
        {
            $item['id']         = $product->id;
            $item['label']      = $product->label;
            $item['price']      = $product->price;
            $item['status']     = $product->status_id;
            $item['isLike']     = $product->rUserLike()->where('user_id',auth()->user()->id)->get()->count() > 0?1:0;
            $item['thumbnail']  = $thumbnailRootUrl.$product->Thumbnail();
            $item['storeName']  = $product->StoreInfo['storeName'];

            $json[] = $item;
        }
        return $json;
    }

    public function loadLives($options)
    {
        $json = [];
        $cond = Live::where('id','>',-1);
        if(isset($options['store_id']))
        {
            $cond = $cond->where('store_id',$options['store_id']);
        }

        if(isset($options['keyword']))
        {
            $cond = $cond->where('title','like','%'.$options['keyword'].'%');
        }
        $lives = $cond->orderBy('created_at','desc')->get();
        foreach($lives as $live)
        {
            $json[] = $this->liveToArray($live);
        }
        return $json;
    }

    public function loadStores($options)
    {
        $response = [];
        $cond = Store::where('id','>',-1);
        if(isset($options['keyword']))
        {
            $cond = $cond->whereHas('rUser',function($query) use($options){
                $query->where('nickname','like','%'.$options['keyword'].'%');
            });
        }

        $stores = $cond->get();
        foreach($stores as $store)
        {
            $item = [];
            $item['id'] = $store->id;
            $item['name'] = $store->rUser->nickname;
            $item['nTotalFollows'] = $store->nTotalFollow;
            $item['icon'] = $store->rUser->cIcon;

            $response[] = $item;
        }

        return $response;
    }

    public function liveToArray(Live $live)
    {
        $item = [];
        if($live != null)
        {
            $item['id']             = $live->id;
            $item['title']          = $live->title;
            $item['tag']            = $live->rTag->label;
            $item['nTotalUsers']    = $live->nTotalUsers;
            $item['thumbnail']      = asset(Storage::url('LivePhoto')).'/'.$live->photo;
            $item['status']         = $live->status_id;
            $item['hls_url']        = $live->hls_url;
            $item['date']           = $live->created_at->format('Y-m-d');
            $item['cid']            = $live->cid;
            $item['cadmin_id']      = $live->cadmin_id;
        }else{
            $item = null;
        }

        return $item;
    }

    public function StoretoArray(Store $store)
    {
        $item = [];
        if($store != null)
        {
            $item = [];
            $item['id'] = $store->id;
            $item['name'] = $store->rUser->nickname;
            $item['description'] = $store->description;
            $item['nTotalFollows'] = $store->nTotalFollow;
            $item['icon'] = $store->rUser->cIcon;
        }else{
            $item = null;
        }

        return $item;
    }

    public function proucttoArray(Product $product)
    {
        $item = [];
        if($product != null)
        {
            $item['id'] = $product->id;
            $item['label'] = $product->label;
            $item['price'] = $product->totalPrice;
            $item['status_id'] = $product->status_id;
            $item['thumbnail'] = asset(Storage::url('ProductPortfolio/').$product->Thumbnail());
            $item['number'] = $product->number;
            $item['ship_days'] = $product->ship_days;
            $item['shipper'] = $product->ship_days;
            $item['storeId'] = $product->store_id;
            $item['storeName'] = $product->StoreInfo != []?$product->StoreInfo['storeName']:'';
            $item['storeThumbnail'] = $product->rStore != null?$product->rStore->rUser->cIcon:'';
        }
        else
        {
            $item = null;
        }
        return $item;
    }

    public function notificationtoArray(Notification $notification)
    {
        $item = [];
        if($notification != null)
        {
            $item['id'] = $notification->id;
            $item['icon'] = asset(Storage::url('NotifyIcon')).'/'.$notification->icon;
            $item['title'] = $notification->title;
            $item['body'] = $notification->body;
            $item['date'] = $notification->created_at->format('Y/m/d H:i');
        }

        return $item;
    }

    public function newstoArray(News $news)
    {
        $item = [];
        if($news != null)
        {
            $item['id']     = $news->id;
            $item['title']  = $news->title;
            $item['body']   = $news->body;
            $item['date']   = $news->created_at->format('Y/m/d H:i');
        }

        return $item;
    }
}
