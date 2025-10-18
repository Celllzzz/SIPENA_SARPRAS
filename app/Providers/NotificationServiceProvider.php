<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\Notifikasi;

class NotificationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('layouts.navigation', function ($view) {
            if (Auth::check() && Auth::user()->role === 'admin') {
                $unreadNotificationsCount = Notifikasi::where('user_id', Auth::id())->where('is_read', false)->count();
                $recentNotifications = Notifikasi::where('user_id', Auth::id())->latest()->take(5)->get();

                $view->with('unreadNotificationsCount', $unreadNotificationsCount)
                     ->with('recentNotifications', $recentNotifications);
            }
        });
    }
}