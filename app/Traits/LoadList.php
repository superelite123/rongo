<?php
namespace App\Traits;

use Storage;
use DB;
use App\Product;
use App\Live;
use App\Store;
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
        $cond = Product::select('products.*',
                        DB::raw('IF(product_user_like.user_id = '.auth()->user()->id.',1,0) as isLike'),
                        'product_portfolio.filename','product_portfolio.order')
                        ->leftJoin('product_user_like','products.id','=','product_user_like.product_id')
                        ->leftJoin('product_portfolio','products.id','=','product_portfolio.product_id')
                        ->whereIn('status_id',$options['status']);
        if(isset($options['store_id']))
        {
            $cond = $cond->where('products.store_id',$options['store_id']);
        }
        if(isset($options['type']))
        {
            if($options['type'] == 2)
            {
                $cond = $cond->where('product_user_like.user_id',auth()->user()->id);
            }
        }

        if(isset($options['keyword']))
        {
            $cond = $cond->where('label','like','%'.$options['keyword'].'%');
        }

        $products = $cond->get();
        $thumbnailRootUrl = asset(Storage::url('ProductPortfolio')).'/';
        $json = [];
        foreach($products as $product)
        {
            $item = [];
            //already exist?
            $flag = $this->searchArray('id',$product->id,$json);
            if($flag != -1)
            {
                $item = $json[$flag];
                $item['thumbnail'] = $product->order == 1?$thumbnailRootUrl.$product->filename:$item['thumbnail'];
                $item['isLike'] = $product->isLike == 1?1:$item['isLike'];

                $json[$flag] = $item;
            }
            else{
                $item['id'] = $product->id;
                $item['label'] = $product->label;
                $item['price'] = $product->price;
                $item['status'] = $product->status_id;
                $item['isLike'] = $product->isLike;
                $item['thumbnail'] = $product->order == 1?$product->filename:'2.png';
                $item['thumbnail'] = $thumbnailRootUrl.$item['thumbnail'];
                $item['storeName'] = $product->StoreInfo['storeName'];

                $json[] = $item;
            }
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
            $item['price'] = $product->price;
            $item['status_id'] = $product->status_id;
            $item['thumbnail'] = $product->Thumbnail();
            $item['number'] = $product->number;
        }
        else
        {
            $item = null;
        }
        return $item;
    }
}
