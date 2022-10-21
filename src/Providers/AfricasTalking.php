<?php

namespace DevMaurice\Kesms\Providers;

use AfricasTalking\SDK\AfricasTalking as SDKAfricasTalking;
use Devmaurice\Kesms\Contracts\Gateway;

class AfricasTalking implements Gateway{

    public $configs;

    public $gateway;

    public function __construct(array $configs)
    {
        $this->configs = $configs;

        $instance = new SDKAfricasTalking(
            $this->configs['username'],
            $this->configs['api_key']
        );

        $this->gateway= $instance->sms();
    }

    public function send($message, $phones = [])
    {
       return $this->gateway->send([
        'to' => $phones,
        'message' => $message
       ]);
    }

    public function balance()
    {
        return $this->gateway->fetchApplicationData();
    }
}
