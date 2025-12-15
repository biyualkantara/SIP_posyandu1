<?php

namespace App\Providers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\Bayi;
use App\Models\Wuspus;
use App\Observers\BayiObserver;
use App\Observers\WuspusObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {    Inertia::share([
            'flash' => function () {
                return [
                    'success' => session('success'),
                    'error'   => session('error'),
                ];
            },
        ]);
        Inertia::share('auth', function () {
            $user = Auth::user();
            if (!$user) return ['user' => null];

            return [
                'user' => [
                    'id_operator' => $user->id_operator,
                    'username'    => $user->username,
                    'nama'        => $user->nama_operator ?? $user->nama ?? $user->username,
                    'role'        => $user->role ?? 'kader',
                ]
            ];
        });

        Bayi::observe(BayiObserver::class);
        Wuspus::observe(WuspusObserver::class);
    }
}