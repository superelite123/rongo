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

        $response['name'] = $store->rUser == null?null:$store->rUser->nickname;
        $response['nTotalFollows'] = $store->nTotalFollow;
        $response['icon'] = $store->rUser->cIcon;

        $isFollow = auth()->user()->rStoreFollow()->where('store_id',$store->id)->first();
        $response['isFollow'] = $isFollow != null?1:0;

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

    public function follows($type) {
        $user = auth()->user();
        $store = $user->rStore;
        $follows = $store->rUsersFollow()->where('type', $type)->get();
        $response = [];
        foreach($follows as $follow)
        {
            $follower = $follow->rUser;
            if($follower != null)
            {
                $data = $this->UsertoArray($follower);
                $block = $follower->rStoreFollow()->where(['type' => 2, 'store_id' => $store->id])->count();
                $data['isBlock'] = ($block == NULL || $block == 0) ? false : true;
                $response[] = $data;
            }
        }

        return response()->json( $response );
    }

    public function products($type) {
        $user = auth()->user();
        $store = $user->rStore;

        $options['status'] = [];
        if ($type == 0) {
            $options['status'][0] = Config::get('constants.pStatus.draft');
            $options['status'][1] = Config::get('constants.pStatus.staged');
            $options['status'][2] = Config::get('constants.pStatus.restaged');
            $options['status'][3] = Config::get('constants.pStatus.sold');
        } else if ($type == 1) {
            $options['status'][0] = Config::get('constants.pStatus.staged');
        } else {
            $options['status'][0] = Config::get('constants.pStatus.draft');
        }

        $options['store_id'] = $store->id;

        $response['products']       = $this->loadProductsWithStore($options);

        return response()->json( $response );
    }

    public function liveStreams($type)
    {
        $user = auth()->user();
        $store = $user->rStore;

        $status = [];
        $status[0] = 2;
        $status[1] = 3;
        $lives = $store->getLiveStreams($status);

        foreach($lives as $live)
        {
            $liveData = $this->liveToArray($live);
            $response[] = $liveData;
        }

        return response()->json( $response );
    }
}
