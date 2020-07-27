<?php

namespace App\Notifications;

use App\Notification as Noti;
use Illuminate\Bus\Queueable;
use Benwilkins\FCM\FcmMessage;
use Illuminate\Notifications\Notification;

class FollowStoreLiveNotification extends Notification
{
    use Queueable;

    public $notification;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Noti $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['fcm'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toFCM($notifiable) {
        $message = new FcmMessage();
        $message->content([
            'title'        => $this->notification->title, 
            'body'         => $this->notification->body, 
            'sound'        => 'default', // Optional 
            'badge'        => 1, // Optional
            'click_action' => '' // Optional
        ])->data([
            'live_id' => $this->notification->live_id,
            'store_id' => $this->notification->store_id,
            'type' => $this->notification->type,
            'icon' => $this->notification->icon,
            'id' =>  $this->notification->id// Optional
        ])->priority(FcmMessage::PRIORITY_HIGH);

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
