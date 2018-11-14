<?php
/**
 * Created by PhpStorm.
 * User: moeen
 * Date: 11/12/18
 * Time: 12:54 PM
 */

namespace MoeenBasra\SmartSms\Provider;


use MoeenBasra\SmartSms\SmartSms;
use Illuminate\Support\ServiceProvider;

class SmartSmsServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function boot()
    {
        $this->publishes([
            __DIR__ . '../Config/sms.php' => config_path('sms.php'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/sms.php', 'sms');

        $this->app->singleton('sms', function () {
            return new SmartSms();
        });
    }
}