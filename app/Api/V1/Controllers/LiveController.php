<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Storage;
//Load Model
use App\User;
use App\Live;
class LiveController extends Controller
{
    /**
     * 2019.6.6
     * Live listing
     */
    public function index()
    {
        $json = ['lives' => []];

        $lives = Live::all();
        foreach($lives as $live)
        {
            $json['lives'][] = $this->toArray($live);
        }
        return response()->json($json);
    }

    public static function toArray(Live $live)
    {
        $item = [];
        if($live != null)
        {
            $item['id']             = $live->id;
            $item['title']          = $live->title;
            $item['tag']            = $live->rTag->label;
            $item['nTotalUsers']    = $live->nTotalUsers;
            $item['thumbnail']      = asset(Storage::url('live_photo')).'/'.$live->photo;
            $item['status']         = $live->status_id;
            $item['date']           = $live->created_at->format('Y-m-d');
        }else{
            $item = null;
        }

        return $item;
    }
}
