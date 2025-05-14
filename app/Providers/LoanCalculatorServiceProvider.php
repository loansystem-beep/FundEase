<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\LoanCalculatorService;

class LoanCalculatorServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Binding the LoanCalculatorService with config values
        $this->app->singleton(LoanCalculatorService::class, function ($app) {
            return new LoanCalculatorService(config('app.loan_calculator'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
