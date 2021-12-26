<?php

namespace CardzApp\Api;

use Codderz\YokoLite\Domain\Uuid\UuidGenerator;
use Codderz\YokoLite\Domain\Uuid\UuidRamseyGenerator;
use Illuminate\Support\ServiceProvider;

class ApiModuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(UuidGenerator::class, UuidRamseyGenerator::class);
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/Presentation/Auth/auth.routes.php');
        $this->loadRoutesFrom(__DIR__ . '/Presentation/Account/account.routes.php');
        $this->loadRoutesFrom(__DIR__ . '/Presentation/Business/business.routes.php');
    }
}
