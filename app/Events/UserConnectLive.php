<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserConnectLive implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $nWatchers;
    public $liveID;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($liveID,$nWatchers)
    {
        $this->nWatchers = $nWatchers;
        $this->liveID = $liveID;
    }
    public function broadcastAs()
    {
        return 'userConnectLive';
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //return 'user-connect-live';
        return new Channel('user-connect-live');
    }
}
