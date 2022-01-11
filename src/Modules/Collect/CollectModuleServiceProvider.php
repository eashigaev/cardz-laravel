<?php

namespace CardzApp\Modules\Collect;

use CardzApp\Modules\Collect\Application\CollectPolicy;
use CardzApp\Modules\Collect\Application\Events\ProgramActiveUpdated;
use CardzApp\Modules\Collect\Application\Listeners\BatchUpdateCardsProgramActive;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use function collect;

class CollectModuleServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot(CollectPolicy $collectPolicy)
    {
        collect($collectPolicy->getRules())->map(
            fn($callback, $ability) => Gate::define($ability, $callback)
        );

        Event::listen(ProgramActiveUpdated::class, BatchUpdateCardsProgramActive::class);
    }
}
