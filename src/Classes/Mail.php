<?php 

namespace App\Classes;

use Mailjet\Client;
use Mailjet\Resources;

class Mail {

    public function send($to_email, $to_name, $subject, $content)
    {
        $mj = new Client($_ENV['MJ_APIKEY_PUBLIC'], $_ENV['MJ_APIKEY_PRIVATE'], true, ['version' => 'v3.1']);
        $body = [
            'Messages' => [
            [
                'From' => [
                'Email' => "morganlaversin@gmail.com",
                'Name' => "La Boutique Française"
                ],
                'To' => [
                [
                    'Email' => $to_email,
                    'Name' => $to_name
                ]
                ],
                'TemplateID' => 3183208,
                'TemplateLanguage' => true,
                'Subject' => $subject,
                'Variables' => [
                    'content' => $content
                ]
            ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}