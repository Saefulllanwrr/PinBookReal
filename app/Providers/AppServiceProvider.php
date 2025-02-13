<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;

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
        // Konfigurasi middleware untuk Filament
        Filament::serving(function () {
            if (Auth::check() && Auth::user()->role !== 'admin') {
                return redirect('/'); // Redirect jika bukan admin
            }
        });
    }
}
