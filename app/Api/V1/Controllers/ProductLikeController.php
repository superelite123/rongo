<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\StoreUserFollow;
use Storage;
class ProductLikeController extends Controller
{
    /**
     * Like Product
     */
    public function index()
    {
        $response = [];
        $thumbnailRootUrl = asset(Storage::url('ProductPortfolio')).'/';
        foreach(auth()->user()->rProductLike as $productKey)
        {
            $product = $productKey->rProduct;
            if( $product != null )
            {
                $item = [];
                $item['id'] = $product->id;
                $item['label'] = $product->label;
                $item['price'] = $product->price;
                $item['thumbnail'] = $thumbnailRootUrl.$product->Thumbnail();
                $response[] = $item;
            }
        }
        return $response;
    }
    /**
     * Follow Store
     */
    public function follow(Request $request)
    {
        $user = auth()->user();
        $store_id = $request->store_id;
        $type = $request->type;
        //now following or unfollo
        $follow = $user->rStoreFollow()->first();
        $result = 1;
        if($follow == null)
        {
            $user->rStoreFollow()->save(new StoreUserFollow(['store_id' => $store_id,'type' => $type]));
            $result = true;
        }
        else
        {
            $follow->delete();
            $result = false;
        }

        return response()->json(['success' => 1,'result' => $result]);
    }
}
