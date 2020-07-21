<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
//Load Model
use App\Live;
class WowzaController extends Controller
{
    private $version = '1.5';
    private $host = 'api.cloud.wowza.com';
    private $path = '/api/v1.5/';
    private $endPoint = 'live_streams';
    protected $wscApiKey = 'HBc8IndlMsdN4CPIWzSH1pWTDrKr2XErJAaFHTGsH7P37y5InaqfXBjq8mD33201';
    protected $wscAccessKey = 'PEVJw0zBw4MQUMS92jG8GTB6JRHedCkdSPzZyK6epeumZSowe0TnDeuPFpM5332d';
    private $config = ['live_stream' => [
        "aspect_ratio_height" => 1080,
        "aspect_ratio_width" => 1920,
        "billing_mode" => "pay_as_you_go",
        "broadcast_location" => "us_west_california",
        "closed_caption_type" => "none",
        "delivery_method" => "push",
        "encoder" => "other_webrtc",
        "hosted_page" => true,
        "hosted_page_sharing_icons" => true,
        "name" => "MyLiveStream1",
        "player_responsive" => true,
        "player_type" => "wowza_player",
        "transcoder_type" => "transcoded"
    ]];
    /**
     * Create Live
     */

    public function createLiveStream($title = 'RongoDefaultLiveStream')
    {
        $this->config['name'] = $title;
        $this->endPoint = 'live_streams';
        $response = $this->getHttpRequest()->post($this->getURL(),$this->config);
        return $response;
    }

    public function startLiveStream($streamID)
    {
        $this->endPoint = 'live_streams/'.$streamID.'/start';
        return $this->getHttpRequest()->put($this->getURL());
        
    }
    public function stopLiveStream($streamID)
    {
        $this->endPoint = 'live_streams/'.$streamID.'/stop';
        $response = $this->getHttpRequest()->put($this->getURL());
        return $response;
    }
    public function publishLiveStream($streamID)
    {

    }
    public function getUsageLiveStream($streamID)
    {
        $this->endPoint = 'usage/stream_targets/'.$streamID.'/live';
        $response = $this->getHttpRequest()->get($this->getURL());
        return json_decode($response,true);
    }
    public function getStateLiveStream($streamID)
    {
        $this->endPoint = 'live_streams/'.$streamID.'/stats';
        return $this->getHttpRequest()->get($this->getURL());
    }
    public function fetchLiveStream($streamID)
    {
        $this->endPoint = 'live_streams/'.$streamID;
        return $this->getHttpRequest()->get($this->getURL());
    }

    public function getURL()
    {
        return 'https://'.$this->host.$this->path.$this->endPoint;
    }

    /**
     * Get Config
     * @Response config array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set Config
     * @param config array
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    private function getSignature($timestamp)
    {
        $string = $timestamp.':'.$this->path.$this->endPoint.':'.$this->wscApiKey;
        return hash_hmac('sha256',$string,$this->wscApiKey);
    }

    private function getHttpRequest()
    {
        $timestamp = Carbon::now()->timestamp;
        return Http::withHeaders([
            'wsc-access-key' => $this->wscAccessKey,
            'wsc-timestamp' => $timestamp,
            'wsc-signature' => $this->getSignature($timestamp),
            'Content-Type' => 'application/json'
        ]);
    }
}
