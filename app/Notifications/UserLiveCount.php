<?php

namespace App\Notifications;

use App\Notification as Noti;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Benwilkins\FCM\FcmMessage;

class UserLiveCount extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $notification;
    public $data;
    public function __construct(Noti $notification,$data)
    {
        $this->notification = $notification;
        $this->data = $data;
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
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }
    public function toFCM($notifiable) {
        $message = new FcmMessage();
        $message->content([
            'title'        => $this->notification->title,
            'body'         => $this->notification->body,
            'sound'        => 'default', // Optional
            'badge'        => 1, // Optional
            'click_action' => '' // Optional
        ])->data($this->data)->priority(FcmMessage::PRIORITY_HIGH);

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
