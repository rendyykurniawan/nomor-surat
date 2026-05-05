<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\URL;


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
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        Paginator::useTailwind();
        // Paginator::useBootstrapFive();

        Event::listen(Login::class, function ($event) {
            ActivityLog::create([
                'user_id'    => $event->user->id,
                'aktivitas'  => 'Login',
                'modul'      => 'Auth',
                'keterangan' => "Login sebagai {$event->user->role}",
                'ip_address' => request()->ip(),
            ]);
        });

        Event::listen(Logout::class, function ($event) {
            ActivityLog::create([
                'user_id'    => $event->user->id,
                'aktivitas'  => 'Logout',
                'modul'      => 'Auth',
                'keterangan' => "Logout: {$event->user->name}",
                'ip_address' => request()->ip(),
            ]);
        });
    }
}
