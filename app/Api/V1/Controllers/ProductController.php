<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use DB;
//Load Model
use App\User;
use App\Product;
use App\ProductUserLike;
//Config
use Config;
class ProductController extends Controller
{
    //'user_id' => auth()->user()->id
    /**
     * Product List with thumbnail
     * which staged to live
     *
     */
    public function index(Request $request)
    {
        $status = [];
        $status[0] = Config::get('constants.pStatus.staged');
        $status[1] = Config::get('constants.pStatus.restaged');
        $status[2] = Config::get('constants.pStatus.sold');
        $cond = Product::select('products.*',
                        DB::raw('IF(product_user_like.user_id = '.auth()->user()->id.',1,0) as isLike'))
                        ->leftJoin('product_user_like','products.id','=','product_user_like.product_id')
                        ->whereIn('status_id',$status);
        if($request->type == 2)
        {
            $cond = $cond->where('product_user_like.user_id',auth()->user()->id);
        }
        $cond = $cond->groupBy('product_id');
        $products =$cond->get();
        $json = ['products' => [],'thumbnailRootUrl' => '','userName' => auth()->user()->nickname];
        foreach($products as $product)
        {
            $item = [];
            $item['id'] = $product->id;
            $item['label'] = $product->label;
            $item['price'] = $product->price;
            $item['status'] = $product->status_id;
            $item['isLike'] = $product->isLike;
            $item['thumbnail'] = $product->thumbnail;

            $json['products'][] = $item;
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
