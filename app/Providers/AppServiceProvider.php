<?php

namespace App\Providers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use App\Services\Helpers\TimeHelper;
use Illuminate\Contracts\Foundation\Application;
use App\Services\TimerService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TimerService::class, function (Application $app) {
            $request = $app->make(Request::class);
            $timerService = new TimerService();
            if($request->task) {
                $timerService->setTask($request->task);
            }

            return $timerService;
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
