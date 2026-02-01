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
            
            // Hitung notif Penerbitan
            $notifPenerbitan = 0;
            if (Auth::check()) {
                if (Auth::user()->role === 'daerah') {
                    // Untuk daerah: permohonan yang status DIPROSES (menunggu balasan)
                    $notifPenerbitan = Permohonan::where('daerah_tujuan', Auth::user()->name)
                        ->where('status', 'DIPROSES')
                        ->count();
                } elseif (Auth::user()->role === 'provinsi') {
                    // Untuk provinsi: permohonan luar yang status DIPROSES (menunggu balasan)
                    $notifPenerbitan = Permohonan::where('wilayah', 'luar')
                        ->where('status', 'DIPROSES')
                        ->count();
                }
            }
            
            $view->with('notifPenerbitan', $notifPenerbitan);
        });
    }
}
