<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahPosyandu = DB::table('duspy')->count();

        return Inertia::render('Dashboard', [
            'jumlahPosyandu' => $jumlahPosyandu,
        ]);
    }
}