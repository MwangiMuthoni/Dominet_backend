<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BillNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($name, $narrative)
    {
        //
        $this->name=$name;
        $this->narrative=$narrative;
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
            ->greeting("Hello {$this->name},")
            ->line("Thank you for subscribing to our {$this->narrative} package with spa. Your billing has been processed successfully.")
            ->line("To login to your account, please click the button below:")
            ->action('Login to your account', url('/').'/login')
            ->line('If you have any questions or need further assistance, feel free to contact our support team.')
            ->line('Thank you for choosing spa!');
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