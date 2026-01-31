<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Permohonan;

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
        // Share authenticated user to all views
        View::composer('*', function ($view) {
            $view->with('role', Auth::user()?->role);
            $view->with('user', Auth::user());
            
            // Hitung notif Penerbitan (hanya untuk user daerah)
            $notifPenerbitan = 0;
            if (Auth::check() && Auth::user()->role === 'daerah') {
                $notifPenerbitan = Permohonan::where('daerah_tujuan', Auth::user()->name)
                    ->where('status', 'DIPROSES')
                    ->count();
            }
            
            $view->with('notifPenerbitan', $notifPenerbitan);
        });
    }
}
