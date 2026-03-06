<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Berita;

// Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DuspyController;
use App\Http\Controllers\KehadiranKaderController;
use App\Http\Controllers\DashboardController; // TAMBAHKAN INI!

use App\Http\Controllers\Posyandu\WuspusBiodataController;
use App\Http\Controllers\Posyandu\WuspusImunisasiController;
use App\Http\Controllers\Posyandu\WuspusKontrasepsiController;
use App\Http\Controllers\Posyandu\WuspusKematianController;

use App\Http\Controllers\Posyandu\Bayi\BayiBiodataController;
use App\Http\Controllers\Posyandu\Bayi\BayiPenimbanganController;
use App\Http\Controllers\Posyandu\Bayi\BayiImunisasiController;
use App\Http\Controllers\Posyandu\Bayi\BayiWafatController;

use App\Http\Controllers\Posyandu\BumilBiodataController;
use App\Http\Controllers\Posyandu\BumilPenimbanganController;
use App\Http\Controllers\Posyandu\BumilImunisasiController;

use App\Http\Controllers\RekapitulasiController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\AiStuntingPredictController;
use App\Http\Controllers\SipintarChatbotController;
use App\Http\Controllers\SipintarStuntingController;

/*
|--------------------------------------------------------------------------
| LANDING
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => Inertia::render('Welcome'))->name('landing');

Route::get('/berita-posyandu', function () {
    return Inertia::render('landingpage/halamanberita', [
        'berita' => Berita::orderByDesc('tanggal_waktu')->get(),
    ]);
});

Route::get('/halaman-posyandu', fn () => Inertia::render('landingpage/halamandaftarposyandu'));
Route::get('/jelajah-edukasi', fn () => Inertia::render('landingpage/jelajahedukasi'));
Route::get('/testing', fn () => Inertia::render('testing'));


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class,'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class,'login']);
});

Route::post('/logout', [AuthController::class,'logout']);


/*
|--------------------------------------------------------------------------
| SUPERADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:superadmin'])->group(function () {
    Route::get('/operator', [OperatorController::class, 'index']);
    Route::get('/operator/create', [OperatorController::class, 'create']);
    Route::post('/operator', [OperatorController::class, 'store']);
    Route::get('/operator/{id}', [OperatorController::class, 'show']);
    Route::get('/operator/{id}/edit', [OperatorController::class, 'edit']);
    Route::put('/operator/{id}', [OperatorController::class, 'update']);
    Route::delete('/operator/{id}', [OperatorController::class, 'destroy']);
});


/*
|--------------------------------------------------------------------------
| AUTH PROTECTED
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // PERBAIKAN: Ganti dari closure ke controller
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'show']);
    Route::get('/profile/edit', [ProfileController::class, 'edit']);
    Route::put('/profile', [ProfileController::class, 'update']);

    /*
    |--------------------------------------------------------------------------
    | POSYANDU
    |--------------------------------------------------------------------------
    */

    Route::prefix('posyandu')->name('posyandu.')->group(function () {
        // ... semua route posyandu Anda tetap sama
    });

    /*
    |--------------------------------------------------------------------------
    | REKAP
    |--------------------------------------------------------------------------
    */

    Route::get('/rekapitulasi', [RekapitulasiController::class, 'showRekapitulasiView']);
    Route::get('/rekapitulasi/{format}/export', [RekapitulasiController::class, 'exportFormat']);

    /*
    |--------------------------------------------------------------------------
    | BERITA
    |--------------------------------------------------------------------------
    */

    Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
    Route::get('/berita/create', [BeritaController::class, 'create'])->name('berita.create');
    Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store');
    Route::get('/berita/{id}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
    Route::put('/berita/{id}', [BeritaController::class, 'update'])->name('berita.update');
    Route::delete('/berita/{id}', [BeritaController::class, 'destroy'])->name('berita.destroy');
    Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');

    /*
    |--------------------------------------------------------------------------
    | SIPINTAR
    |--------------------------------------------------------------------------
    */

    Route::get('/sipintar/chatbot', [SipintarChatbotController::class, 'index']);
    Route::post('/sipintar/chatbot/api', [SipintarChatbotController::class, 'handle']);

    Route::get('/sipintar/stunting', [SipintarStuntingController::class, 'index']);
    Route::post('/sipintar/stunting/analisis/{id_bayi}', [SipintarStuntingController::class, 'analisis']);

    Route::post('/ai/stunting/predict-all', [AiStuntingPredictController::class, 'predictForAll']);
});