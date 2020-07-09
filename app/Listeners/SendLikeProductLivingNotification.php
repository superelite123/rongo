<?php

namespace App\Listeners;

use App\Events\LikeProductLiving;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Notifications\LikeProductLive;

class SendLikeProductLivingNotification implements ShouldQueue
{
     /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'listeners';

    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
    public $delay = 60;
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  LikeProductLiving  $event
     * @return void
     */
    public function handle(LikeProductLiving $event)
    {
        //
        auth()->user()->notify(new LikeProductLive($event->live,$event->product));
    }

    /**
     * Determine whether the listener should be queued.
     *
     * @param  \App\Events\OrderPlaced  $event
     * @return bool
     */
    public function shouldQueue(LikeProductLiving $event)
    {
        return true;
    }

    /**
     * Handle a job failure.
     *
     * @param  \App\Events\OrderShipped  $event
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(LikeProductLiving $event, $exception)
    {
        //
    }
    /**
     * Get the name of the listener's queue.
     *
     * @return string
     */
    public function viaQueue()
    {
        return 'listeners';
    }
}
