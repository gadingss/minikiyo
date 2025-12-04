<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // ✅ tambahkan ini!
use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use App\Http\Responses\LoginResponse;

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
        $this->app->bind(LoginResponseContract::class, LoginResponse::class);

        // ✅ Paksa semua URL jadi HTTPS jika pakai ngrok (atau hosting dengan HTTPS)
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
