<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;

class FireBase
{

    protected $apiurl = "https://fcm.googleapis.com/v1/projects/yalla-namshi/messages:send";
    //protected $access_token = "31e63313ca6d78eb7cd6d829da0145019a0c54b2";

    protected $title          = "";
    protected $body           = "";
    protected $token          = "";
    //protected $token          = [];
    protected $target_screen  = "notifications_page";
    protected $target_id      = "0";
    protected $by             = "system";
    protected $message_to     = "";

    private function getAccessToken()
    {
        $credentialsFilePath = base_path('yalla-namshi-firebase-adminsdk-v9wpr-4db7f867d0.json');
        $client = new \Google_Client();
        $client->setAuthConfig($credentialsFilePath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->refreshTokenWithAssertion();
        $token = $client->getAccessToken();
        $access_token = $token['access_token'];
        return $access_token;
    }

    private function getHeaders()
    {
        return [
            "Authorization: Bearer {$this->getAccessToken()}",
            "Content-Type: application/json",
        ];
    }



    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    public function setToken($token)
    {
        $this->token = $token;
        //$this->token   = (is_array($token)) ? $token : [$token];
        return $this;
    }

    public function setTargetScreen($target_screen)
    {
        $this->target_screen   = $target_screen;
        return $this;
    }

    public function setTargetId($target_id)
    {
        $this->target_id   = $target_id;
        return $this;
    }

    public function setMessageTo($message_to)
    {
        $this->message_to = $message_to;
        return $this;
    }


    private function getNotification()
    {
        return [
            'title' => $this->title,
            'body'  => $this->body,
        ];
    }

    private function getMessages()
    {
        if ($this->message_to == "all") {
            $fields = [
                'message' => [
                    'topic'        => 'all',
                    'notification' => $this->getNotification(),
                    'data' => [
                        'target_screen' => $this->target_screen,
                        'target_id'     => $this->target_id,
                    ],
                ],
            ];
        } else if ($this->message_to == "users") {
            $fields = [
                'message' => [
                    'topic'        => 'users',
                    'notification' => $this->getNotification(),
                    'data' => [
                        'target_screen' => $this->target_screen,
                        'target_id'     => $this->target_id,
                    ],
                ],
            ];
        } else if ($this->message_to == "providers") {
            $fields = [
                'message' => [
                    'topic'        => 'providers',
                    'notification' => $this->getNotification(),
                    'data' => [
                        'target_screen' => $this->target_screen,
                        'target_id'     => $this->target_id,
                    ],
                ],
            ];
        } else {
            $fields = [
                'message' => [
                    'token'        => $this->token,
                    //'token'      => ($this->token[0]) ? $this->token[0] : [],
                    'notification' => $this->getNotification(),
                    'data' => [
                        'target_screen' => $this->target_screen,
                        'target_id'     => $this->target_id,
                    ],
                ],
            ];
        }


        //dd(json_encode($fields));
        //dd($this->message_to);
        //dd($this->title);
        //dd($this->token);
        return json_encode($fields);
    }


    public function build()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiurl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getMessages());
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        // curl_exec($ch);
        $result = curl_exec($ch);
        curl_close($ch);
        //dd($this->token);
        //  dd($result);
        // return $result;
    }
}
