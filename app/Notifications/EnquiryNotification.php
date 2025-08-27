<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EnquiryNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($name, $phone, $email,$title, $id)
    {
        //
        $this->name=$name;
        $this->phone=$phone;
        $this->email=$email;
        $this->title=$title;
        $this->id=$id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
         return (new MailMessage)
                    ->line("{$this->name}")
                    ->line("{$this->phone}")
                    ->line("{$this->email}")
                    ->line("Made an enquiry about {$this->title}")
                    ->action('Click here to view the listing', url('/listing/'.$this->id))
                    ->line('Thank you for using spa');
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