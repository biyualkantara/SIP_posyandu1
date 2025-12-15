<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot(): void
    {
        Gate::define('superadmin', function ($user) {
            return in_array(
                strtolower($user->username),
                ['admin', 'superadmin']
            );
        });
    }
}