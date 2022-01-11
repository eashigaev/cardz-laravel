<?php

namespace CardzApp\Modules\Shared;

use Codderz\YokoLite\Domain\Uuid\UuidGenerator;
use Codderz\YokoLite\Domain\Uuid\UuidRamseyGenerator;
use Illuminate\Support\ServiceProvider;

class SharedModuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(UuidGenerator::class, UuidRamseyGenerator::class);
    }

    public function boot()
    {
    }
}
