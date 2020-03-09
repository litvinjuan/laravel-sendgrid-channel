<?php

namespace LaravelSendGridChannel;
use GuzzleHttp\Client;

use Illuminate\Notifications\Notification;

class SendGridTransactionalChannel
{

    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toSendGrid($notifiable);

        $client = new Client();
        $client->post('https://api.sendgrid.com/v3/mail/send',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . config('mail.sendgrid.api-key'),
                    'Content-Type' => 'application/json ',
                ],
                'json' => [
                    'from' => [
                        'email' => config('mail.from.address'),
                        "name" => config('app.name'),
                    ],
                    'personalizations' => [
                        [
                            'to' => $data['to'],
                        ],
                    ],
                    'template_id' => $data['template_id']
                ],
            ]
        );
    }

}
