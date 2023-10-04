<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Factory;

class FirebaseNotification extends Notification
{
    use Queueable;
    private $messaging;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        $this->messaging = (new Factory)
            ->withServiceAccount(storage_path('app/public/goblins-50e94-firebase-adminsdk-jyq12-f3bb0ca541.json'))
            ->createMessaging();

    }

    public function via($notifiable)
    {
        $message = CloudMessage::withTarget('token', $notifiable->device_token)
            ->withNotification(['title' => 'Your Notification Title', 'body' => 'Your Notification Body'])
            ->withData(['custom_data' => 'your_custom_data']);

        return $this->messaging->send($message);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
