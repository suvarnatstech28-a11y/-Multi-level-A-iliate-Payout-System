<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    protected $policies = [
        // ...
    ];
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('menu-customers', function ($user) {
            return $user->added_from === 'admin';
        });

        Gate::define('menu-sales', function ($user) {
            //return in_array($user->added_from, ['manager']);
             return $user->added_from === 'admin';
        });

         Gate::define('menu-products', function ($user) {
            return $user->added_from === 'customer';
        });

        Gate::define('menu-purchase', function ($user) {
            //return in_array($user->added_from, ['manager']);
             return $user->added_from === 'customer';
        });
    }
}
