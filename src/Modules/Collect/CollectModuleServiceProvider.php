<?php

namespace CardzApp\Modules\Collect;

use CardzApp\Modules\Collect\Application\Policy;
use CardzApp\Modules\Collect\Application\Repositories\CardRepository;
use CardzApp\Modules\Collect\Application\Repositories\ProgramRepository;
use CardzApp\Modules\Collect\Infrastructure\Repositories\EloquentCardRepository;
use CardzApp\Modules\Collect\Infrastructure\Repositories\EloquentProgramRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use function collect;

class CollectModuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CardRepository::class, EloquentCardRepository::class);
        $this->app->singleton(ProgramRepository::class, EloquentProgramRepository::class);
    }

    public function boot(Policy $policy)
    {
        collect($policy->getRules())->map(
            fn($callback, $ability) => Gate::define($ability, $callback)
        );
    }
}
