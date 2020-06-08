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
        $json = ['lives' => [],'thumbnailRootUrl' => asset(Storage::url('live_photo'))];

        $lives = Live::all();
        foreach($lives as $live)
        {
            $item = [];
            $item['id']             = $live->id;
            $item['title']          = $live->title;
            $item['tag']            = $live->rTag->label;
            $item['nTotalUsers']    = $live->nTotalUsers;
            $item['thumbnail']      = $live->photo;
            $item['status']         = $live->status_id;

            $json['lives'][] = $item;
        }
        return response()->json($json);
    }
}
