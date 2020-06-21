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
use App\Traits\LoadList;
class ProductController extends Controller
{
    //'user_id' => auth()->user()->id
    /**
     * Product List with thumbnail
     * which staged to live
     *
     */
    use LoadList;
    public function index(Request $request)
    {
        $options['type'] = $request->type;
        return response()->json($this->loadProducts($options));
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
                $response['lives'][] = $this->liveToArray($live);
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

    public function addLikeProduct(Request $request){

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
