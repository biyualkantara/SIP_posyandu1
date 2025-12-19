<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return Inertia::render('auth/Login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $operator = Operator::where('username', $credentials['username'])->first();

        if (!$operator) {
            return back()->withErrors(['username' => 'User tidak ditemukan']);
        }

        // bcrypt
        if (Str::startsWith($operator->password, '$2y$')) {
            if (!Hash::check($credentials['password'], $operator->password)) {
                return back()->withErrors(['password' => 'Password salah']);
            }
        }
        // sha1 lama
        elseif (sha1($credentials['password']) === $operator->password) {
            $operator->password = Hash::make($credentials['password']);
            $operator->save();
        } else {
            return back()->withErrors(['password' => 'Password salah']);
        }

        Auth::login($operator);
        $request->session()->regenerate();

        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}