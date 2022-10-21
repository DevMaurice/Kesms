<?php

namespace DevMaurice\Kesms;

use Devmaurice\Kesms\SmsManager;
use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{

     /* Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/sms.php' => config_path('sms.php'),
        ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('sms', function ($app){
            return new SmsManager($app);
        });

        $this->app->singleton('sms.gateway', function ($app) {
            return $app['sms']->driver();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'sms','sms.gateway'
        ];
    }
}
