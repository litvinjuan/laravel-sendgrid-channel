<?php

namespace litvinjuan\LaravelSendGridChannel;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/sendgrid.php' => config_path('sendgrid.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/sendgrid.php', 'sendgrid');
    }


}
