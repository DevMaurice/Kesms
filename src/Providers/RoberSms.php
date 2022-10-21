<?php

namespace DevMaurice\Kesms\Providers;

use Devmaurice\Kesms\Contracts\Gateway;
use Illuminate\Support\Facades\Http;

class RoberSms implements Gateway{
    public $configs;

    public $gateway;

    public function __construct(array $configs)
    {
        $this->configs = $configs;
    }

    public function send($message, $phones = [])
    {

        $response = Http::post($this->configs['url'],[]);

        return $response;
    }

    public function balance()
    {
        return [];
    }
}
