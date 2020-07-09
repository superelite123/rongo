<?php

namespace App\Listeners;

use App\Events\LikeProductSale;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendLikeProductSaleNotification
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
     * @param  LikeProductSale  $event
     * @return void
     */
    public function handle(LikeProductSale $event)
    {
        //
    }
}
