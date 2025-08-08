<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot(): void
    {
        // Define Gates
        Gate::define('admin', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('manager', function (User $user) {
            return $user->isManager() || $user->isAdmin();
        });

        Gate::define('staff', function (User $user) {
            return $user->isStaff() || $user->isManager() || $user->isAdmin();
        });
    }
}