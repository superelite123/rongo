<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Store;
use App\Traits\LoadList;
use Config;
class StoreController extends Controller
{
    use LoadList;
    /**
     * 6.6
     */
    public function index()
    {
        return response()->json($this->loadStores([]));
    }

    /**
     * Show Store Detail
     */
    public function show($id)
    {
        $store = Store::find($id);
        $response = [];
        $response['id'] = $store->id;
        $response['background']     = $store->Background;
        $response['isFollow']       = $store->rUsersFollow()->where(['user_id' => auth()->user()->id,'type' => 1]);
        $response['evaluation']     = $store->Evaluation;
        $response['description']    = $store->description;
        $response['explantion']     = $store->Explantions;
        //Products
        $options['type'] = 1;
        $options['store_id'] = $id;
        $options['status'] = [];
        $options['status'][0] = Config::get('constants.pStatus.staged');
        $options['status'][1] = Config::get('constants.pStatus.restaged');
        $options['status'][2] = Config::get('constants.pStatus.sold');
        $response['products']       = $this->loadProducts($options);
        //Lives
        $response['lives']          = $this->loadLives(['store_id' => $id]);
        //Seller Info
        $response['seller'] = [];
        $seller = $store->rUser;
        $response['seller']['name'] = $seller->nickname;
        $response['seller']['icon'] = $seller->cIcon;

        return response()->json( $response );
    }

    public function toArray(Store $store)
    {
        $item = [];
        if($live != null)
        {
            $item = [];
            $item['id'] = $store->id;
            $item['description'] = $store->description;
            $item['nTotalFollows'] = $store->nTotalFollows;
            $item['thumbnail'] = '';
        }else{
            $item = null;
        }

        return $item;
    }
}
