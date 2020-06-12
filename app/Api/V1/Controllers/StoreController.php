<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Store;
class StoreController extends Controller
{
    /**
     * 6.6
     */
    public function index()
    {
        $response = ['stores' => []];
        $stores = Store::all();
        foreach($stores as $store)
        {
            $item = [];
            $item['id'] = $store->id;
            $item['name'] = $store->rUser->nickname;
            $item['nTotalFollows'] = $store->nTotalFollows;
            $item['icon'] = $store->rUser->cIcon;

            $response['stores'][] = $item;
        }

        return response()->json($response);
    }

    /**
     * @Show Store Detail
     */
    public function show($id)
    {

    }

    public static function toArray(Store $store)
    {
        $item = [];
        if($live != null)
        {
            $item = [];
            $item['id'] = $store->id;
            $item['description'] = $store->description;
            $item['nTotalFollows'] = $store->nTotalFollows;
            $item['thumbnail'] = asset(Storage::url('store_portfolio')).'/'.$store->rThumbnail->filename;
        }else{
            $item = null;
        }

        return $item;
    }
}
