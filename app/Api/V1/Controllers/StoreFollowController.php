<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Traits\LoadList;
use App\StoreUserFollow;
class StoreFollowController extends Controller
{
    use LoadList;
    /**
     * Followed Users
     */
    public function index($type)
    {
        $response = [];
        //Pick only following
        $storeIDs = auth()->user()->rStoreFollow()->where('type',$type)->get();
        foreach($storeIDs as $storeID)
        {
            $store = $storeID->rStore;
            if($store != null)
            {
                $response[] = $this->StoretoArray($store);
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
