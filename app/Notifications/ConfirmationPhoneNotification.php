<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\AfricasTalkingChannel;

class ConfirmationPhoneNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($phone,$code)
    {
        //
        $this->code=$code;
        $this->phone=$phone;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [AfricasTalkingChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */

    public function toAficasTalking($notifiable)
    {
        $message='Your phone number verification code is. '.$this->code;
        return [
            'message' => $message,
            'phone' => $this->phone,
        ];
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