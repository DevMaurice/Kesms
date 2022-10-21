<?php

namespace Devmaurice\Kesms;

use InvalidArgumentException;
use Illuminate\Support\Facades\Log;
use Devmaurice\Kesms\Contracts\Gateway;
use Devmaurice\Kesms\Providers\MoveSms;
use Devmaurice\Kesms\Providers\RoberSms;
use Devmaurice\Kesms\Providers\AfricasTalking;
use Devmaurice\Kesms\Contracts\Factory as SmsContract;

class SmsManager implements SmsContract {

    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * The array of resolved cache gateways.
     *
     * @var array
     */
    protected $gateways = [];

    /**
     * Create a new Cache manager instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     *
     */
    public function gateway($name = null)
    {
        Log::alert("Hello from gateway implementation");
        $name = $name ?: $this->getDefaultGateway();

        return $this->gateways[$name] = $this->get($name);
    }

     /**
     * Get a sms driver instance.
     *
     * @param  string|null  $driver
     * @return \Illuminate\Contracts\Cache\Repository
     */
    public function driver($driver = null)
    {
        Log::alert("Hello from driver call");
        return $this->gateway($driver);
    }

    /**
     * Attempt to get the gateway from the at sms.
     *
     * @param  string  $name
     * @return \Illuminate\Contracts\Cache\Repository
     */
    protected function get($name)
    {
        return $this->gateways[$name] ?? $this->resolve($name);
    }

    /**
     * Resolve the given store.
     *
     * @param  string  $name
     * @return \Illuminate\Contracts\Cache\Repository
     *
     * @throws \InvalidArgumentException
     */
    protected function resolve($name)
    {
        $config = $this->getConfig($name);

        if (is_null($config)) {
            throw new InvalidArgumentException("Sms gateway [{$name}] is not defined.");
        }

        $smsMethod = 'create'.ucfirst($config['driver']).'Gateway';

        if (method_exists($this, $smsMethod)) {
            return $this->{$smsMethod}($config);
        } else {
            throw new InvalidArgumentException("Gateway [{$config['driver']}] is not supported.");
        }

    }

    public function createAtGateway($configs)
    {
        return $this->repository(
            new AfricasTalking($configs)
        );
    }

    public function createMoveGateway($configs)
    {
        return $this->repository(
            new MoveSms($configs)
        );
    }

    public function createRoberGateway($configs)
    {
        return $this->repository(
            new RoberSms($configs)
        );
    }

     /**
     * Create a new cache repository with the given implementation.
     *
     * @param Devmaurice\Kesms\Cotracts\Gateway
     * @return Devmaurice\Kesms\Repository
     */
    public function repository(Gateway $gateway)
    {
        return new Repository($gateway);
    }

     /**
     * Get the gateway configuration.
     *
     * @param  string  $name
     * @return array|null
     */
    protected function getConfig($name)
    {
        if (! is_null($name) && $name !== 'null') {
            return $this->app['config']["sms.gateways.{$name}"];
        }

        return ['driver' => 'null'];
    }

     /**
     * Get the default cache gateway name.
     *
     * @return string
     */
    public function getDefaultGateway()
    {
        return $this->app['config']['sms.default'];
    }

    /**
     * Set the default sms Gateway name.
     *
     * @param  string  $name
     * @return void
     */
    public function setDefaultGateway($name)
    {
        $this->app['config']['sms.default'] = $name;
    }

    /**
     * Dynamically call the default gateway instance.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->gateway()->$method(...$parameters);
    }
}
