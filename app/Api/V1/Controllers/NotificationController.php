<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use App\Traits\LoadList;
/**
 * Notification Related
 */
use App\Notifications\LikeProductLive;
class NotificationController extends Controller
{
    use LoadList;
    public function index()
    {
        $notifications = Notification::whereIn('receiver',[0,auth()->user()->id])->get();
        $response = [];
        foreach($notifications as $notification)
        {
            $response[] = $this->notificationtoArray($notification);
        }

        return response()->json($response);
    }

    public function sendLikeProductLive(Request $request)
    {
        auth()->user()->notify(new AccountActivated);
    }
}
