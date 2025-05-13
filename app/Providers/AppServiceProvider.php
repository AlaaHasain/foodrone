<?php

namespace App\Providers;

use App\Models\Reservation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
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
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrapFive();
        View::composer('admin.layouts.*', function ($view) {
            $pendingReservationsCount = Reservation::where('status', 'pending')->count();
            $view->with('pendingReservationsCount', $pendingReservationsCount);
        });
    }
}
