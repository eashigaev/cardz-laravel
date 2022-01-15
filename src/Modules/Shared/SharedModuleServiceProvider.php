<?php

namespace CardzApp\Modules\Shared;

use Codderz\YokoLite\Domain\Uuid\UuidGenerator;
use Codderz\YokoLite\Domain\Uuid\UuidRamseyGenerator;
use Codderz\YokoLite\Infrastructure\Registry\Registry;
use Codderz\YokoLite\Infrastructure\Registry\SimpleRegistry;
use Illuminate\Support\ServiceProvider;

class SharedModuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(UuidGenerator::class, UuidRamseyGenerator::class);
        $this->app->singleton(Registry::class, SimpleRegistry::class);
    }

    public function boot()
    {
    }
}
