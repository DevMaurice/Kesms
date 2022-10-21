<?php

namespace DevMaurice\Kesms\Providers;

use Devmaurice\Kesms\Contracts\Gateway;
use Illuminate\Support\Facades\Http;

class MoveSms implements Gateway{
    public $configs;

    public $gateway;

    public function __construct(array $configs)
    {
        $this->configs = $configs;
    }

    public function send($message, $phones = [])
    {
        $data = [
            'action' => 'compose',
            'username' => $this->configs['username'],
            'api_key' => $this->configs['apiKey'],
            'sender' => $this->configs['sender'],
            'to' => $phones,
            'message' => $message,
            'msgtype' => 5,
            'dlr' => 0,
        ];

        $response = Http::post($this->configs['url'],$data);

        return $response;
    }

    public function balance()
    {
        return [];
    }
}
