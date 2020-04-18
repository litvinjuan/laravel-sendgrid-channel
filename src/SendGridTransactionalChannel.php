<?php

namespace litvinjuan\LaravelSendGridChannel;

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
                    'Authorization' => 'Bearer ' . config('sendgrid.api-key'),
                    'Content-Type' => 'application/json ',
                ],
                'json' => [
                    'from' => [
                        'email' => $data['from']['email'],
                        "name" => $data['from']['name'],
                    ],
                    'personalizations' => [
                        [
                            'to' => $data['to'],
                            'dynamic_template_data' => $data['data'],
                        ],
                    ],
                    'mail_settings' => [
                        'sandbox_mode' => [
                            'enable' => config('sendgrid.sandbox-enabled') !== false,
                        ],
                    ],
                    'template_id' => $data['template_id'],
                ],
            ]
        );
    }

}
