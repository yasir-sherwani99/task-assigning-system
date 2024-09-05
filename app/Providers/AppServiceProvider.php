<?php

namespace App\Providers;

use App\Traits\NotificationTrait;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    use NotificationTrait;

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
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        view()->composer(['layouts.partials._notifications'], function ($view) {
            $notifications = auth()->user()->notifications()->take(3)->get();
            $notificationDetails = $this->getNotificationDetails($notifications);
    
            $view->with('notifications', $notificationDetails);
        });
    }
}
