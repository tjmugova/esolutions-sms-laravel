<?php

namespace Tjmugova\EsolutionsSms;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Client\Factory;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use Tjmugova\EsolutionsSms\Channels\EsolutionsSmsChannel;

class EsolutionsSmsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(EsolutionsSms::class, function (Application $app) {
            return new EsolutionsSms(
                $app->make(Factory::class),
                $app['config']['esolutions-sms']
            );
        });
        $this->mergeConfigFrom(
            __DIR__ . '/../config/esolutions-sms.php',
            'esolutions-sms'
        );
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('esolutionsSms', function ($app) {
                return new EsolutionsSmsChannel(
                    $app->make(EsolutionsSms::class),
                    $app['config']['esolutions-sms']['sms_from'],
                    $app->make(Dispatcher::class),
                );
            });
        });
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/esolutions-sms.php' => $this->app->configPath('esolutions-sms.php'),
            ], 'esolutions-sms');
        }
    }
}