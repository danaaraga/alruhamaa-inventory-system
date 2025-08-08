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
        // Define Gates - Admin bisa akses semua
        Gate::define('admin', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('manager', function (User $user) {
            return in_array($user->role, ['manager', 'admin']); // Admin juga bisa akses manager features
        });

        Gate::define('staff', function (User $user) {
            return in_array($user->role, ['staff', 'manager', 'admin']); // Semua role bisa akses staff features
        });

        // Specific permissions
        Gate::define('manage-users', function (User $user) {
            return $user->role === 'admin'; // Hanya admin yang bisa manage users
        });

        Gate::define('manage-products', function (User $user) {
            return in_array($user->role, ['manager', 'admin']); // Manager dan Admin bisa manage products
        });

        Gate::define('view-inventory', function (User $user) {
            return in_array($user->role, ['staff', 'manager', 'admin']); // Semua bisa view inventory
        });

        Gate::define('manage-reports', function (User $user) {
            return in_array($user->role, ['manager', 'admin']); // Manager dan Admin bisa manage reports
        });
    }
}