<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Illuminate\Http\Request;
use App\Models\Operator;
use Illuminate\Support\Facades\Hash;

class FortifyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Halaman login
        Fortify::loginView(fn () => inertia('auth/LoginLanding'));

        // Login custom ke tabel operator
        Fortify::authenticateUsing(function (Request $request) {
            $user = Operator::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }

            return null;
        });
    }
}