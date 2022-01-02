<?php

namespace CardzApp\Api;

use CardzApp\Api\Collect\Application\CollectBootstrap;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;
use Codderz\YokoLite\Domain\Uuid\UuidRamseyGenerator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class ApiModuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(UuidGenerator::class, UuidRamseyGenerator::class);
    }

    public function boot(CollectBootstrap $collectBootstrap)
    {
        $this->loadRoutesFrom(__DIR__ . '/Auth/Presentation/auth.routes.php');
        $this->loadRoutesFrom(__DIR__ . '/Account/Presentation/account.routes.php');
        $this->loadRoutesFrom(__DIR__ . '/Business/Presentation/business.routes.php');
        $this->loadRoutesFrom(__DIR__ . '/Collect/Presentation/collect.routes.php');

        collect($collectBootstrap->getPolicies())->map(
            fn($callback, $ability) => Gate::define($ability, $callback)
        );
    }
}
