<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($name, $phone, $email, $subject, $message)
    {
        //
        $this->name=$name;
        $this->phone=$phone;
        $this->email=$email;
        $this->subject=$subject;
        $this->message=$message;
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
                    ->line("Subject: {$this->subject}")
                    ->line("{$this->message}")
                    ->line("Name: {$this->name}")
                    ->line("Phone: {$this->phone}")
                    ->line("Email: {$this->email}")
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