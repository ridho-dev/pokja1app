<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        // User yang boleh akses hanya jika dia adalah administrator
        Gate::define('manage-users', function (User $user) {
            return $user->role->name === 'Admin';
        });
    }
}
