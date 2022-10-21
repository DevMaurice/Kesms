<?php

namespace Devmaurice\Kesms;

use Devmaurice\Kesms\Contracts\Gateway;
use Devmaurice\Kesms\Contracts\Repository as ContractsRepository;
use Illuminate\Support\Facades\Log;

class Repository implements ContractsRepository {

    /**
     * The sms gateway implementation.
     *
     * @var \Devmaurice\Kesms\Contracts\Gateway
     */
    protected $gateway;

    /**
     * Create a new cache repository instance.
     *
     * @param  \Devmaurice\Kesms\Contracts\gatewaygateway  $gateway
     * @return void
     */
    public function __construct(Gateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function send($message, $phones = [])
    {
        return $this->gateway->send($message,$phones);
    }

    public function sendOne($message, $phone = null)
    {
        return $this->gateway->send($message,$phone);
    }

    public function sendMany($message, $phones = [])
    {
        return $this->gateway->send($message,$phones);
    }

    public function getBalance()
    {
        return $this->gateway->balance();
    }


     /**
     * Get the cache gateway implementation.
     *
     * @return \Devmaurice\Kesms\Contracts\Gateway
     */
    public function getGateway()
    {
        return $this->gateway;
    }

     /**
     * Handle dynamic calls into macros or pass missing methods to the gateway.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->gateway->$method(...$parameters);
    }

    /**
     * Clone gateway repository instance.
     *
     * @return void
     */
    public function __clone()
    {
        $this->gateway = clone $this->gateway;
    }
}
