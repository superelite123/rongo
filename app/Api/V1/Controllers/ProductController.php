<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use DB;
use Storage;
//Load Model
use App\User;
use App\Product;
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
        $json = ['products' => [],'thumbnailRootUrl' => asset(Storage::url('product_portfolio')),'userName' => auth()->user()->nickname];
        foreach($products as $product)
        {
            $item = [];
            //already exist?
            $flag = $this->searchArray('id',$product->id,$json['products']);
            if($flag != -1)
            {
                $item = $json['products'][$flag];
                $item['thumbnail'] = $product->order == 1?$product->filename:$item['thumbnail'];
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
                $json['products'][] = $item;
            }
        }
        return response()->json(['products' => $json]);
    }

    public function show(Product $product)
    {
        return $product;
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
