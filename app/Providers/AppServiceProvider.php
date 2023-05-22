<?php

namespace App\Providers;

use App\Models\AdminNotification;
use App\Models\Frontend;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Laravel\Fortify\Fortify;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Fortify::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public function boot()
    {
        $general = getGen();
        $notification = getNotify();
        $viewShare['general'] = $general;
        $viewShare['notification'] = $notification;
        view()->share($viewShare);

        view()->composer('panels.navbar', function ($view) {
            $view->with([
                'adminNotifications' => AdminNotification::where('read_status', 0)->with('user')->orderBy('id', 'desc')->get(),
            ]);
        });

        view()->composer('partials.seo', function ($view) {
            $seo = Frontend::where('data_keys', 'seo.data')->first();
            $view->with([
                'seo' => $seo ? $seo->data_values : $seo,
            ]);
        });
        view()->composer('panels.user.navbar', function ($view) {
            $view->with([
                'user' => Auth::user(),
            ]);
        });

        if ($general->force_ssl) {
            URL::forceScheme('https');
        }
    }
}