<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Storage;
use Carbon\Carbon;
//Load Model
use App\User;
use App\Live;
class LiveController extends WowzaController
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

    /**
     * Create Live
     * @param
     * array
     */
    public function create(Request $request)
    {
        return $this->createLiveStream();
    }

    public function start($id)
    {
        $status = $this->startLiveStream(Live::find($id)->stream_id);
        return $status;
    }
    public function stop($id)
    {
        //$streamID = Live::find($id)->stream_id;
        $status = $this->stopLiveStream('vwpq3lr1');
        return $status;
    }
    public function publish($id)
    {
        $response = $this->publishLiveStream(Live::find($id)->stream_id);
    }
    public function state($id)
    {
        return $this->getStateLiveStream(Live::find($id)->stream_id);
    }
    public function fetch($id)
    {
        return $this->fetchLiveStream(Live::find($id)->stream_id);
    }
    public function view($id)
    {
        return response()->json($this->toArray(Live::find($id)));
    }
    public function getThumbnail($id)
    {

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
            $item['thumbnail']      = asset(Storage::url('LivePhoto')).'/'.$live->photo;
            $item['status']         = $live->status_id;
            $item['hls_url']        = $live->hls_url;
            $item['date']           = $live->created_at->format('Y-m-d');
        }else{
            $item = null;
        }

        return $item;
    }
}
