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
        $this->loadRoutesFrom(__DIR__ . '/Auth/Presentation/auth.routes.php');
        $this->loadRoutesFrom(__DIR__ . '/Account/Presentation/account.routes.php');
        $this->loadRoutesFrom(__DIR__ . '/Business/Presentation/business.routes.php');
        $this->loadRoutesFrom(__DIR__ . '/Collect/Presentation/collect.routes.php');
    }
}
