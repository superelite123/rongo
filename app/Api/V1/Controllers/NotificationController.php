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
        $user = auth()->user();
        $notifications = Notification::where('receiver', $user->id)->get();
        $response = [];
        foreach($notifications as $notification)
        {
            if(!($notification->type == 0 || $notification->type == null)) {
                $response[] = $notification;
            }
            //$this->notificationtoArray($notification);
        }

        return response()->json($response);
    }

    public function markAsRead($id) {
        $notification = Notification::find($id);
        $notification->readStatus = 1;
        $notification->save();

        return response()->json(['success' => true]);
    }

    public function sendLikeProductLive(Request $request)
    {
        auth()->user()->notify(new AccountActivated);
    }
}
