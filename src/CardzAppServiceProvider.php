<?php

namespace CardzApp;

use CardzApp\Api\ApiGatewayServiceProvider;
use CardzApp\Modules\Account\AccountModuleServiceProvider;
use CardzApp\Modules\Auth\AuthModuleServiceProvider;
use CardzApp\Modules\Business\BusinessModuleServiceProvider;
use CardzApp\Modules\Collect\CollectModuleServiceProvider;
use CardzApp\Modules\Shared\SharedModuleServiceProvider;
use Illuminate\Support\ServiceProvider;

class CardzAppServiceProvider extends ServiceProvider
{
    public static function providers()
    {
        return [
            self::class,
            ApiGatewayServiceProvider::class,
            AccountModuleServiceProvider::class,
            AuthModuleServiceProvider::class,
            BusinessModuleServiceProvider::class,
            CollectModuleServiceProvider::class,
            SharedModuleServiceProvider::class
        ];
    }

    public function register()
    {
    }

    public function boot()
    {
    }
}
