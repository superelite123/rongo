<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use DB;
use Storage;
//Load Model
use App\User;
use App\Product;
use App\Live;
use App\ProductUserLike;
//Config
use Config;
use App\Helper\CommonFunction;
class ProductController extends Controller
{
    //'user_id' => auth()->user()->id
    /**
     * Product List with thumbnail
     * which staged to live
     *
     */
    use CommonFunction;
    public function index(Request $request)
    {
        $status = [];
        $status[0] = Config::get('constants.pStatus.staged');
        $status[1] = Config::get('constants.pStatus.restaged');
        $status[2] = Config::get('constants.pStatus.sold');
        $cond = Product::select('products.*',
                        DB::raw('IF(product_user_like.user_id = '.auth()->user()->id.',1,0) as isLike'),
                        'product_portfolio.filename','product_portfolio.order')
                        ->leftJoin('product_user_like','products.id','=','product_user_like.product_id')
                        ->leftJoin('product_portfolio','products.id','=','product_portfolio.product_id')
                        ->whereIn('status_id',$status);
        if($request->type == 2)
        {
            $cond = $cond->where('product_user_like.user_id',auth()->user()->id);
        }

        $products =$cond->get();
        $thumbnailRootUrl = asset(Storage::url('ProductPortfolio')).'/';
        $json = ['products' => []];
        foreach($products as $product)
        {
            $item = [];
            //already exist?
            $flag = $this->searchArray('id',$product->id,$json['products']);
            if($flag != -1)
            {
                $item = $json['products'][$flag];
                $item['thumbnail'] = $product->order == 1?$thumbnailRootUrl.$product->filename:$item['thumbnail'];
                $item['isLike'] = $product->isLike == 1?1:$item['isLike'];

                $json['products'][$flag] = $item;
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

                $json['products'][] = $item;
            }
        }
        return response()->json($json);
    }

    public function show($id){
        $product = Product::find($id);
        $response = ['product' => null];
        if($product != null){
            $response = [];
            $response['id'] = $product->id;
            $response['label'] = $product->label;
            $response['number'] = $product->number;
            $response['description'] = $product->description;
            $response['price'] = $product->price;
            $response['nLikes'] = $product->rUserLike()->count();
            $response['isLike'] = $product->IsLike;
            //relatied store
            $response = array_merge($response,$product->StoreInfo);

            //Related Lives
            $response['lives'] = [];
            $lives = $product->rLive;
            foreach($lives as $liveId)
            {
                $live = Live::find($liveId->live_id);
                $response['lives'][] = LiveController::toArray($live);
            }
            //portfolios
            $response['portfolios'] = [];
            foreach($product->rPortfolio()->orderby('order')->get() as $portfolio)
            {
                $response['portfolios'][] = asset(Storage::url('ProductPortfolio')).'/'.$portfolio->filename;
            }
        }
        return response()->json(['product' => $response]);
    }

    public function like(Request $request){

        $product = Product::find($request->product_id);

        $bUserLike = $product->rUserLike()->where('user_id' , auth()->user()->id)->first();
        if($bUserLike == null)
        {
            $product->rUserLike()->saveMany([
                new ProductUserLike(['user_id' => auth()->user()->id])
            ]);
            return response()->json(['like' => 1]);
        }
        else{
            $bUserLike->delete();
            return response()->json(['like' => 0]);
        }
    }

    public function store(Request $request)
    {

    }

    public function update(Request $request,$id)
    {

    }

    public function delete($id)
    {

    }
}
