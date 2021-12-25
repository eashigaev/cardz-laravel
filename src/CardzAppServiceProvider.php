<?php

namespace CardzApp;

use CardzApp\Api\ApiModuleServiceProvider;
use Illuminate\Support\ServiceProvider;

class CardzAppServiceProvider extends ServiceProvider
{
    public static function providers()
    {
        return [
            self::class,
            ApiModuleServiceProvider::class
        ];
    }

    public function register()
    {
    }

    public function boot()
    {
    }
}
