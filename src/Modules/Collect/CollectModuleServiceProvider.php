<?php

namespace CardzApp\Modules\Collect;

use CardzApp\Modules\Collect\Application\CollectBootstrap;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use function collect;

class CollectModuleServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot(CollectBootstrap $collectBootstrap)
    {
        collect($collectBootstrap->getPolicies())->map(
            fn($callback, $ability) => Gate::define($ability, $callback)
        );

        $collectBootstrap->registerListeners();
    }
}
