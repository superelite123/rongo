<?php

namespace App\Listeners;

use App\Events\FollowStoreLiving;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendFollowStoreLivingNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  FollowStoreLiving  $event
     * @return void
     */
    public function handle(FollowStoreLiving $event)
    {
        //
    }
}
