<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Store;
use App\StoreExplantion;
use App\StoreBackground;
use App\StoreUserFollow;
use App\StoreHasTag;
use App\Tag;
use Storage;
class UserStoreController extends Controller
{
    /**
     * get Store
     */
    public function index()
    {
        $store_id = auth()->user()->rStore->id;
        $store = Store::find($store_id);
        $response = [];
        $response['id'] = $store->id;
        $response['description']    = $store->description;

        $rootUrl = asset(Storage::url('StoreBackground')).'/'.$store_id.'/';
        $response['backgrounds']    = [];
        foreach($store->rBackground()->orderBy('order')->get() as $bg)
        {
            $response['backgrounds'][] = $rootUrl.$bg['filename'];
        }
        $response['explantions'] = [];
        $rootUrl = asset(Storage::url('StoreExplantion')).'/'.$store_id.'/';
        foreach($store->rExplantion()->orderBy('order')->get() as $explain)
        {
            $response['explantions'][] = $rootUrl.$explain['filename'];
        }
        $response['tags'] = [];
        foreach($store->rTag as $tag)
        {
            $response['tags'][] = $tag->rTag->label;
        }

        return response()->json( $response );
    }

    /**
     * Store
     */
    public function store(Request $request)
    {
        $store_id = auth()->user()->rStore->id;
        $store = Store::find($store_id);
        //store description
        $store->description = $request->description;
        $store->save();
        //store avatar
        if(strlen($request->avatar) > 100)
        {
            $filename = auth()->user()->icon;

            $image = base64_decode($request->avatar);

            if(!Storage::disk('user_icon')->put($filename, $image ) )
            {
                return -1;
            }
        }
        //store explaintion
        $store->rExplantion()->delete();
        //Storage::disk('store_explantion')->delete(Storage::disk('store_explantion')->allFiles($store_id));
        $insertData = [];
        foreach($request->explantions as $key => $explantion)
        {
            $file_name = $key.'.png';
            //if updated image
            if(strlen($explantion) > 100)
            {
                $image =  base64_decode($explantion);
                $filename = $store_id.'/'.$file_name;
                Storage::disk('store_explantion')->put($filename, $image );
            }
            $insertData[] = new StoreExplantion(['filename' => $file_name,'order' => $key]);
        }
        $store->rExplantion()->saveMany($insertData);
        //store background
        $store->rBackground()->delete();
        //Storage::disk('store_explantion')->delete(Storage::disk('store_explantion')->allFiles($store_id));
        $insertData = [];
        foreach($request->backgrounds as $key => $background)
        {
            $file_name = $key.'.png';
            //if updated image
            if(strlen($background) > 100)
            {
                $image =  base64_decode($background);
                $filename = $store_id.'/'.$file_name;
                Storage::disk('store_background')->put($filename, $image );
            }
            $insertData[] = new StoreBackground(['filename' => $file_name,'order' => $key]);
        }
        $store->rBackground()->saveMany($insertData);
        //store tags
        $store->rTag()->delete();
        $insertData = [];
        foreach($request->tags as $key => $label)
        {
            $tag = Tag::where('label',$label)->first();
            if($tag != null)
            {
                $tag_id = $tag->id;
            }
            else
            {
                $tag = new Tag;
                $tag->label = $label;
                $tag->save();
                $tag_id = $tag->id;
            }
            $insertData[] = new StoreHasTag(['tag_id' => $tag_id]);
        }
        $store->rTag()->saveMany($insertData);
        return response()->json(['success'=>1]);
    }
}
