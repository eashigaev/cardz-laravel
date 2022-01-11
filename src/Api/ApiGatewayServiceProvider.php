<?php

namespace CardzApp\Api;

use Illuminate\Support\ServiceProvider;

class ApiGatewayServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/Auth/auth.routes.php');
        $this->loadRoutesFrom(__DIR__ . '/Account/account.routes.php');
        $this->loadRoutesFrom(__DIR__ . '/Business/business.routes.php');
        $this->loadRoutesFrom(__DIR__ . '/Collect/collect.routes.php');
    }
}
