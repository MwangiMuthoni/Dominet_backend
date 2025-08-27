<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use AfricasTalking\SDK\AfricasTalking;
use GuzzleHttp\Client;

class AfricasTalkingChannel
{
    public function send($notifiable, Notification $notification)
    {
        $smsData = $notification->toAficasTalking($notifiable);

        $username = config('app.at_username');
        $apiKey   = config('app.at_key');
        $AT       = new AfricasTalking($username, $apiKey);
        $sms      = $AT->sms();
        $result   = $sms->send([
            'to'      => $smsData['phone'],
            'from'    =>config('app.at_from'),
            'message' => $smsData['message']
        ]);
        
        return ['message' => 'SMS sent successfully'];
    }
}