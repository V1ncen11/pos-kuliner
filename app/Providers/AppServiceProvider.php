<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        \Illuminate\Pagination\Paginator::useBootstrapFive();

        \Illuminate\Support\Facades\View::composer('layouts.admin', function ($view) {
            $count = \App\Models\Pesanan::whereIn('status', ['menunggu_verifikasi', 'belum_bayar'])->count();
            $view->with('unread_orders_count', $count);
        });
    }
}
