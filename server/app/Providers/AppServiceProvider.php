<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

//Phân trang bằng bootstrap
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Phân trang bằng bootstrap
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
    }
}
