<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Helpers\TimeHelper;
use Illuminate\Contracts\Foundation\Application;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TimeHelper::class, function (Application $app) {
            return new TimeHelper();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
