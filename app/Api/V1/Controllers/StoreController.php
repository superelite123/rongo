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
        $json = ['stores' => [],'thumbnailRootUrl' => asset(Storage::url('store_portfolio'))];
        $stores = Store::all();
        foreach($stores as $store)
        {
            $item = [];
            $item['id'] = $store->id;
            $item['description'] = $store->description;
            $item['nTotalFollows'] = $store->nTotalFollows;
            $item['thumbnail'] = $store->rThumbnail->filename;

            $json['stores'][] = $item;
        }

        return response()->json($json);
    }
}
