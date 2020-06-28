<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Storage;
use Carbon\Carbon;
//Load Model
use App\User;
use App\Live;
use GetStream\StreamChat\Client;
use Config;
use App\Traits\LoadList;
class LiveController extends WowzaController
{
    use LoadList;
    /**
     * 2019.6.6
     * Live listing
     */
    public function index()
    {
        return response()->json($this->loadLives([]));
    }

    /**
     * Create Live
     * @param
     * array
     */
    public function create(Request $request)
    {
        //Use logged in user as Seller
        $user = auth()->user();
        $response = [
            'success' => 1,
            'cid' => null,
            'cadmin_id' => null
        ];

        //Create LiveStream
        //$liveStreamReponse = json_decode($this->createLiveStream($request->title));
        $liveStreamReponse = ['id' => '23232df',
                              'player_hls_playback_url' => 'https://cdn3.wowza.com/1/dlFQWTU5eW5uUGIx/NWtYMlFt/hls/live/playlist.m3u8'];

        /**
         * Create Chat Channel
         */
        $client = new Client(Config::get('constants.CHAT.STREAM_KEY'),Config::get('constants.CHAT.SECERT_KEY'));
        //Channel ID
        $cid = uniqid();
        $cadmin = [
            'id' => $user->chat_id,
            'role' => 'admin',
            'name' => 'admin',
        ];
        $client->updateUser($cadmin);
        $channelConfig = [
                          'name' => $request->title,
                          'typing_events' => true,
                          'read_events' => true,
                          'connect_events' => true,
                         ];
        // Instantiate a livestream type channel with id homeShopping
        $channel = $client->Channel("livestream", $cid, $channelConfig);
        unset($channelConfig['name']);
        $channelType = $client->updateChannelType('livestream',$channelConfig);
        //print_r($channelType);
        // Create the channel
        $state = $channel->create($cadmin['id']);
        //Create Live
        // $live = new Live;
        // $live->photo        = '2.png';
        // $live->title        = $request->title;
        // $live->store_id     = $user->rStore->id;
        // $live->tag_id       = $this->registerTag($request->tag);
        // $live->status_id    = 1;
        // $live->stream_id    = $liveStreamReponse['id'];
        // $live->hls_url      = $liveStreamReponse['player_hls_playback_url'];
        // $live->cid          = $cid;
        // $live->cadmin_id    = $cadmin['id'];
        //$live->save();

        $response['id']             = $live->id;
        $response['cid']            = $live->cid;
        $response['cadmin_id']      = $live->cadmin_id;

        return response()->json($response);
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
    public function produts($id)
    {
        $response = [];
        $products = Live::find($id)->rProducts;
        foreach($products as $product)
        {
            $response[] = $this->proucttoArray($product->rProduct);
        }
        return response()->json($response);
    }
    public function view($id)
    {
        $response = [];

        $live = Live::find($id);

        $response = $this->liveToArray($live);
        $response['nViewer'] = $this->getUsageLiveStream($live->stream_target_id)['stream_target']['unique_viewers'];
        $response['evaluation'] = $live->rEvaluation()->count();
        $response['seller'] = [];

        $seller = $live->rStore->rUser;

        $response['seller']['store_id'] = $live->rStore->id;
        $response['seller']['name'] = $seller->nickname;
        $response['seller']['icon'] = $seller->cIcon;

        return response()->json( $response );
    }
    public function createChatClient()
    {
        return new Client(Config::get('constants.CHAT.STREAM_KEY'),Config::get('constants.CHAT.SECERT_KEY'));
    }
    public function getThumbnail($id)
    {

    }

}
