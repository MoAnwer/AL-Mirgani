<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Number;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (app()->environment('local')) {
            URL::forceScheme('http');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Number::useLocale('ar');

        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
    }
}
