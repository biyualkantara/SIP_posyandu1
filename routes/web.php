<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Berita;

// Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DuspyController;
use App\Http\Controllers\KehadiranKaderController;

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

    Route::get('/dashboard', fn () => Inertia::render('Dashboard'))->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'show']);
    Route::get('/profile/edit', [ProfileController::class, 'edit']);
    Route::put('/profile', [ProfileController::class, 'update']);

    /*
    |--------------------------------------------------------------------------
    | POSYANDU
    |--------------------------------------------------------------------------
    */

Route::prefix('posyandu')->name('posyandu.')->group(function () {

        // ======================
        // DATA UMUM
        // ======================

         Route::get('/data-umum', [DuspyController::class, 'index'])
        ->name('data-umum.index');

        Route::get('/data-umum/create', [DuspyController::class, 'create'])
            ->name('data-umum.create');

        Route::post('/data-umum/store-multiple', [DuspyController::class, 'storeMultiple'])
            ->name('data-umum.storeMultiple');

        Route::get('/data-umum/export-pdf', [DuspyController::class, 'exportPdf'])
            ->name('data-umum.exportPdf');

        Route::get('/data-umum/{id}', [DuspyController::class, 'show'])
            ->name('data-umum.show');

        Route::get('/data-umum/{id}/edit', [DuspyController::class, 'edit'])
            ->name('data-umum.edit');

        Route::put('/data-umum/{id}', [DuspyController::class, 'update'])
            ->name('data-umum.update');

        Route::delete('/data-umum/{id}', [DuspyController::class, 'destroy'])
            ->name('data-umum.destroy');

        // ======================
        // KEHADIRAN KADER
        // ======================
        Route::get('/kehadiran-kader', [KehadiranKaderController::class, 'index']);
        Route::get('/kehadiran-kader/create', [KehadiranKaderController::class, 'create']);
        Route::post('/kehadiran-kader/store-multiple', [KehadiranKaderController::class, 'storeMultiple']);

        Route::get('/kehadiran-kader/{id}', [KehadiranKaderController::class, 'show']);
        Route::get('/kehadiran-kader/{id}/edit', [KehadiranKaderController::class, 'edit']);
        Route::put('/kehadiran-kader/{id}', [KehadiranKaderController::class, 'update']);
        Route::delete('/kehadiran-kader/{id}', [KehadiranKaderController::class, 'destroy']);

        // ======================
        // WUSPUS BIODATA
        // ======================
        Route::get('/wuspus', [WuspusBiodataController::class, 'index']);
        Route::get('/wuspus/create', [WuspusBiodataController::class, 'create']);
        Route::post('/wuspus/store-multiple', [WuspusBiodataController::class, 'storeMultiple']);
        Route::get('/wuspus/{id}', [WuspusBiodataController::class, 'show']);
        Route::get('/wuspus/{id}/edit', [WuspusBiodataController::class, 'edit']);
        Route::put('/wuspus/{id}', [WuspusBiodataController::class, 'update']);
        Route::delete('/wuspus/{id}', [WuspusBiodataController::class, 'destroy']);


        // ======================
        // WUSPUS IMUNISASI
        // ======================
        Route::get('/wuspus-imun', [WuspusImunisasiController::class, 'index']);
        Route::get('/wuspus-imun/create', [WuspusImunisasiController::class, 'create']);
        Route::post('/wuspus-imun/store-multiple', [WuspusImunisasiController::class, 'storeMultiple']);
        Route::get('/wuspus-imun/{id}', [WuspusImunisasiController::class, 'show']);
        Route::get('/wuspus-imun/{id}/edit', [WuspusImunisasiController::class, 'edit']);
        Route::put('/wuspus-imun/{id}', [WuspusImunisasiController::class, 'update']);
        Route::delete('/wuspus-imun/{id}', [WuspusImunisasiController::class, 'destroy']);


        // ======================
        // WUSPUS KONTRASEPSI
        // ======================
        Route::get('/wuspus-kontrasepsi', [WuspusKontrasepsiController::class, 'index']);
        Route::get('/wuspus-kontrasepsi/create', [WuspusKontrasepsiController::class, 'create']);
        Route::post('/wuspus-kontrasepsi/store-multiple', [WuspusKontrasepsiController::class, 'storeMultiple']);
        Route::get('/wuspus-kontrasepsi/{id}', [WuspusKontrasepsiController::class, 'show']);
        Route::get('/wuspus-kontrasepsi/{id}/edit', [WuspusKontrasepsiController::class, 'edit']);
        Route::put('/wuspus-kontrasepsi/{id}', [WuspusKontrasepsiController::class, 'update']);
        Route::delete('/wuspus-kontrasepsi/{id}', [WuspusKontrasepsiController::class, 'destroy']);


        // ======================
        // WUSPUS KEMATIAN
        // ======================
        Route::get('/wuspus-kematian', [WuspusKematianController::class, 'index']);
        Route::get('/wuspus-kematian/create', [WuspusKematianController::class, 'create']);
        Route::post('/wuspus-kematian/store-multiple', [WuspusKematianController::class, 'storeMultiple']);
        Route::get('/wuspus-kematian/{id}', [WuspusKematianController::class, 'show']);
        Route::get('/wuspus-kematian/{id}/edit', [WuspusKematianController::class, 'edit']);
        Route::put('/wuspus-kematian/{id}', [WuspusKematianController::class, 'update']);
        Route::delete('/wuspus-kematian/{id}', [WuspusKematianController::class, 'destroy']);

        // ======================
        // BAYI
        // ======================

        Route::get('/bayi', [BayiBiodataController::class, 'index']);
        Route::get('/bayi/create', [BayiBiodataController::class, 'create']);
        Route::post('/bayi/store-multiple', [BayiBiodataController::class, 'storeMultiple']);
        Route::get('/bayi/{id}', [BayiBiodataController::class, 'show']);
        Route::get('/bayi/{id}/edit', [BayiBiodataController::class, 'edit']);
        Route::put('/bayi/{id}', [BayiBiodataController::class, 'update']);
        Route::delete('/bayi/{id}', [BayiBiodataController::class, 'destroy']);

        Route::get('/bayi-pnb', [BayiPenimbanganController::class, 'index']);
        Route::get('/bayi-pnb/create', [BayiPenimbanganController::class, 'create']);
        Route::post('/bayi-pnb/store-multiple', [BayiPenimbanganController::class, 'storeMultiple']);

        Route::get('/bayi-imun', [BayiImunisasiController::class, 'index']);
        Route::get('/bayi-imun/create', [BayiImunisasiController::class, 'create']);
        Route::post('/bayi-imun/store-multiple', [BayiImunisasiController::class, 'storeMultiple']);

        Route::get('/bayi-wafat', [BayiWafatController::class, 'index']);
        Route::get('/bayi-wafat/create', [BayiWafatController::class, 'create']);
        Route::post('/bayi-wafat/store-multiple', [BayiWafatController::class, 'storeMultiple']);

        // ======================
        // BUMIL
        // ======================

        Route::get('/bumil', [BumilBiodataController::class, 'index']);
        Route::get('/bumil/create', [BumilBiodataController::class, 'create']);
        Route::post('/bumil/store-multiple', [BumilBiodataController::class, 'storeMultiple']);

        Route::get('/bumil-imun', [BumilImunisasiController::class, 'index']);
        Route::get('/bumil-imun/create', [BumilImunisasiController::class, 'create']);
        Route::post('/bumil-imun/store-multiple', [BumilImunisasiController::class, 'storeMultiple']);

        Route::get('/bumil-pnb', [BumilPenimbanganController::class, 'index']);
        Route::get('/bumil-pnb/create', [BumilPenimbanganController::class, 'create']);
        Route::post('/bumil-pnb/store-multiple', [BumilPenimbanganController::class, 'storeMultiple']);

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

    Route::get('/berita', [BeritaController::class, 'index'])->name('berita');
    Route::get('/berita/create', [BeritaController::class, 'create'])->name('berita.create');
    Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store');
    Route::get('/berita/{id}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
    Route::put('/berita/{id}', [BeritaController::class, 'update'])->name('berita.update');
    Route::delete('/berita/{id}', [BeritaController::class, 'destroy'])->name('berita.destroy');

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