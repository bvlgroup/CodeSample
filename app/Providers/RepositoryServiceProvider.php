<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {

    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        $this->app->bind(\App\Repositories\CodeMains\CodeMainRepositoryInterface::class, \App\Repositories\CodeMains\CodeMainRepository::class);
        $this->app->bind(\App\Repositories\Banner\BannerRepositoryInterface::class, \App\Repositories\Banner\BannerRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        //
    }

}
