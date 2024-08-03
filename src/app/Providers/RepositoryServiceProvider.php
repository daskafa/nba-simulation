<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Interfaces\TeamRepositoryInterface::class,
            \App\Repositories\TeamRepository::class
        );

        $this->app->bind(
            \App\Interfaces\FixtureRepositoryInterface::class,
            \App\Repositories\FixtureRepository::class
        );

        $this->app->bind(
            \App\Interfaces\PlayerStatRepositoryInterface::class,
            \App\Repositories\PlayerStatRepository::class
        );

        $this->app->bind(
            \App\Interfaces\TeamStatRepositoryInterface::class,
            \App\Repositories\TeamStatRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
