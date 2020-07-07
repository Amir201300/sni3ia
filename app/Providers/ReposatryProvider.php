<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ReposatryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            'App\Interfaces\HandleDataInterface',
            'App\Reposatries\HandleDataReposatry'
        );

        // Rate Binding
        $this->app->bind(
            'App\Interfaces\RateInterface',
            'App\Reposatries\RateReposatry'
        );

        // Rate Binding
        $this->app->bind(
            'App\Interfaces\Work_shopInterface',
            'App\Reposatries\Work_shopReposatry'
        );
    }
}
