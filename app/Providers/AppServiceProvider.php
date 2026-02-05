<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// 1. JANGAN LUPA BARIS INI (Import Paginator)
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
        // 2. Tambahkan baris ini agar pagination berubah jadi gaya Bootstrap
        Paginator::useBootstrapFive();
    }
}
