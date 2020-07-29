<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Storage;
use Carbon\Carbon;
use App\LiveEvaluation;
//Load Model
use App\User;
use App\Live;
use App\LiveHasUser;
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
        
        $user = auth()->user();
        $response = [];
        $response = [
        'success' => 1,
        'cid' => null,
        'cadmin_id' => null
        ];
        $liveStreamReponse = [];
        //Create LiveStream
        $this->createLiveStream($request->title);
        $liveStreamReponse = json_decode($this->createLiveStream($request->title),true);
        //can not create live stream
        if(!isset($liveStreamReponse['live_stream']))
        {
        return abort(500, 'can not create Live stream');
        }
        $liveStreamReponse = $liveStreamReponse['live_stream'];

        // $liveStreamReponse = ['id' => '23232df',
        // 'player_hls_playback_url' => 'https://cdn3.wowza.com/1/NURVSXRVTzBmV1Fl/dkxkWlQy/hls/live/playlist.m3u8',
        // 'source_connection_information' => [
        // 'sdp_url' => 'wss://2b5ba6.entrypoint.cloud.wowza.com/webrtc-session.json',
        // 'application_name' => 'wss://2b5ba6.entrypoint.cloud.wowza.com/webrtc-session.json',
        // 'stream_name' => 'wss://2b5ba6.entrypoint.cloud.wowza.com/webrtc-session.json',
        // ]
        // ];

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
        'typing_events' => false,
        'read_events' => false,
        'connect_events' => false,
        ];
        // Instantiate a livestream type channel with id homeShopping
        $channel = $client->Channel("livestream", $cid, $channelConfig);
        unset($channelConfig['name']);
        $channelType = $client->updateChannelType('livestream',$channelConfig);
        //end chat part

        //Create Live
        $live = new Live;
        $live->title = $request->title;
        $live->store_id = 1;
        $live->tag_id = $this->registerTag($request->tag);
        $live->status_id = 1;
        $live->stream_id = $liveStreamReponse['id'];
        $live->hls_url = $liveStreamReponse['player_hls_playback_url'];
        $live->photo = 'aa.png';
        $live->cid = $cid;
        $live->cadmin_id = $cadmin['id'];

        $live->save();
        //Save Thumbnail
        $filename = $live->id.'.png';
        if(!Storage::disk('live_photo')->put($filename, base64_decode($request->thumbnail) ) )
        {
        return -1;
        }
        $live->photo = $filename;
        $live->save();

        $this->startLiveStream($liveStreamReponse['id']);
        $productInsertData = [];
        foreach($request->products as $_product)
        {
        $productInsertData[] = new LiveHasProduct([
        'product_id' => $_product['id'],
        'qty' => $_product['addQty'],
        'sold_qty' => 0
        ]);
        $product = Product::find($_product['id']);
        $product->qty -= $_product['addQty'];
        $product->status_id = Config::get('constants.pStatus.staged');
        $product->save();
        }
        $live->rProducts()->saveMany($productInsertData);

        // $response['id'] = $live->id;
        // $response['liveData'] = $liveStreamReponse['source_connection_information'];
        // $response['hls_url'] = $live->hls_url;
        // $response['channel'] = $channel;
        // $response['cid'] = $live->cid;
        // $response['cadmin_id'] = $live->cadmin_id;

        $follows = $user->rStore->rUsersFollow;
        foreach ($follows as $follow) {
        $follow->rUser->notify(new FollowStoreLiveNotification());
        }
        // $live = Live::find(90);
        // $live->cid = $cid;
        // $live->cadmin_id = $cadmin['id'];
        // $live->save();

        $response['id'] = $live->id;
        $response['liveData'] = $liveStreamReponse['source_connection_information'];
        $response['hls_url'] = $live->hls_url;
        $response['channel'] = $channel;
        $response['channel_id'] = $live->cid;
        $response['cadmin_id'] = $live->cadmin_id;
        $response['chat_user_id'] = $user->chat_id;
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
    public function watchedLives()
    {
        $response = [];
        $user = auth()->user();
        $live_ids = LiveHasUser::where('user_id',$user->id)->get();
        foreach($live_ids as $live_id)
        {
            $item = [];
            $live = $live_id->rLive;
            $item['id'] = $live->id;
            $item['title'] = $live->title;
            $item['tag'] = $live->rTag->label;
            $item['date'] = $live->created_at->format('Y/m/d');
            $item['thumbnail'] =  asset(Storage::url('LivePhoto')).'/'.$live->photo;
            $item['nWatchers'] = $live->nWatchers;

            $response[] = $item;
        }

        return $response;
    }
    public function getThumbnail($id)
    {

    }

    public function like(Request $request) {
        $user = auth()->user();
        $liveId = $request->live_id;
        $live = Live::find($liveId);
        $evaluation = $live->rEvaluation()->where('user_id', $user->id)->first();
        $response = [];
        if ($evaluation == null) {
            $evaluation = new LiveEvaluation();
            $evaluation->user_id = $user->id;
            $evaluation->live_id = $liveId;
            $evaluation->save();
            $response['success'] = true;
            $response['isLike'] = true;
        } else {
            $evaluation->delete();
            $response['success'] = true;
            $response['isLike'] = false;
        }

        return response()->json($response);
    }

}
