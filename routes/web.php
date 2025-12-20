<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DuspyController;
use App\Http\Controllers\KehadiranKaderController;

use App\Http\Controllers\Posyandu\WuspusBiodataController;
use App\Http\Controllers\Posyandu\WuspusImunisasiController;
use App\Http\Controllers\Posyandu\WuspusKontrasepsiController;
use App\Http\Controllers\Posyandu\WuspusKematianController;

use App\Http\Controllers\BayiController;

use App\Http\Controllers\Posyandu\BumilBiodataController;
use App\Http\Controllers\Posyandu\BumilPenimbanganController;
use App\Http\Controllers\Posyandu\BumilImunisasiController;

use App\Http\Controllers\RekapitulasiController;

use App\Http\Controllers\AiStuntingPredictController;
use App\Http\Controllers\SipintarChatbotController;
use App\Http\Controllers\SipintarStuntingController;

use App\Http\Controllers\OperatorController;

// Landing Page
Route::get('/', function () {
    return Inertia::render('Welcome'); 
})->name('landing');
Route::get('/testing', function () {
    return Inertia::render('testing');
})->name('testing');
// Auth
Route::get('/login', [AuthController::class,'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout']);

// Auth Protected Routes
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', fn () => Inertia::render('Dashboard'))
        ->name('dashboard');
    
    // Edit Profil
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::get('/profile/edit', [ProfileController::class, 'edit']);
    Route::put('/profile', [ProfileController::class, 'update']);

    // BAGIAN BAYI
     Route::prefix('data_bayi')->group(function () {
        Route::get('/biodata', [BayiController::class, 'showBiodataView']);
        Route::get('/biodata/add', [BayiController::class, 'showAddBiodataView']);
        Route::post('/biodata', [BayiController::class, 'handlePostBiodata']);
        Route::get('/biodata/{id}/edit', [BayiController::class,'showEditBiodataView']);
        Route::put('/biodata/{id}', [BayiController::class,'handleUpdateBiodata']);
        Route::delete('/biodata/{id}', [BayiController::class,'handleDeleteBiodata']);
        Route::get('/penimbangan', [BayiController::class, 'showPenimbanganView']);
        Route::get('/penimbangan/tambah', [BayiController::class, 'showAddPenimbanganView']);
        Route::post('/penimbangan', [BayiController::class,'handlePostPenimbangan']);
        Route::get('/penimbangan/{id}/edit', [BayiController::class, 'showEditPenimbanganView']);
        Route::put('/penimbangan/{id}', [BayiController::class, 'handleUpdatePenimbangan']);
        Route::delete('/penimbangan/{id}', [BayiController::class, 'handleDeletePenimbangan']);
        Route::get('/imunisasi', [BayiController::class, 'showImunisasiView']);
        Route::get('/imunisasi/tambah', [BayiController::class, 'showAddImunisasiView']);
        Route::post('/imunisasi', [BayiController::class, 'handlePostImunisasi']);
        Route::get('/imunisasi/{id}/edit', [BayiController::class, 'showEditImunisasiView']);
        Route::put('/imunisasi/{id}', [BayiController::class, 'handleUpdateImunisasi']);
        Route::delete('/imunisasi/{id}', [BayiController::class, 'handleDeleteImunisasi']);
        Route::get('/kematian', [BayiController::class, 'showKematianView']);
        Route::get('/kematian/tambah', [BayiController::class, 'showAddKematianView']);
        Route::post('/kematian', [BayiController::class, 'handlePostKematian']);
        Route::get('/kematian/{id}/edit', [BayiController::class, 'showEditKematianView']);
        Route::put('/kematian/{id}', [BayiController::class, 'handleUpdateKematian']);
        Route::delete('/kematian/{id}', [BayiController::class, 'handleDeleteKematian']);
    });

     // POSYANDU - DATA UMUM
    Route::prefix('posyandu/data-umum')->name('posyandu.data-umum.')->group(function () {
        Route::get('/', [DuspyController::class, 'index'])->name('index');
        Route::get('/create', [DuspyController::class, 'create'])->name('create');
        Route::post('/store-multiple', [DuspyController::class, 'storeMultiple'])->name('storeMultiple');

        Route::get('/export-pdf', [DuspyController::class, 'exportPdf'])->name('exportPdf');

        Route::get('/{id}', [DuspyController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [DuspyController::class, 'edit'])->name('edit');
        Route::put('/{id}', [DuspyController::class, 'update'])->name('update');
        Route::delete('/{id}', [DuspyController::class, 'destroy'])->name('destroy');
    });
    //  KADER
    Route::prefix('posyandu')->group(function () {
        Route::get('kehadiran-kader', [KehadiranKaderController::class, 'index']);
        Route::get('kehadiran-kader/create', [KehadiranKaderController::class, 'create']);
        Route::post('kehadiran-kader/store-multiple', [KehadiranKaderController::class, 'storeMultiple']);

        Route::get('kehadiran-kader/{id}', [KehadiranKaderController::class, 'show']);
        Route::get('kehadiran-kader/{id}/edit', [KehadiranKaderController::class, 'edit']);
        Route::put('kehadiran-kader/{id}', [KehadiranKaderController::class, 'update']);
        Route::delete('kehadiran-kader/{id}', [KehadiranKaderController::class, 'destroy']);

    // Wuspus
    // Wuspus Biodata      
    Route::get('/wuspus', [WuspusBiodataController::class, 'index']);
    Route::get('/wuspus/create', [WuspusBiodataController::class, 'create']);
    Route::post('/wuspus/store-multiple', [WuspusBiodataController::class, 'storeMultiple']);
    Route::get('/wuspus/{id}', [WuspusBiodataController::class, 'show']);
    Route::get('/wuspus/{id}/edit', [WuspusBiodataController::class, 'edit']);
    Route::put('/wuspus/{id}', [WuspusBiodataController::class, 'update']);
    Route::delete('/wuspus/{id}', [WuspusBiodataController::class, 'destroy']);
    
    // WUSPUS Imunisasi
    Route::get('/wuspus-imun', [WuspusImunisasiController::class, 'index']);
    Route::get('/wuspus-imun/create', [WuspusImunisasiController::class, 'create']);
    Route::post('/wuspus-imun/store-multiple', [WuspusImunisasiController::class, 'storeMultiple']);
    Route::get('/wuspus-imun/{id}', [WuspusImunisasiController::class, 'show']);
    Route::get('/wuspus-imun/{id}/edit', [WuspusImunisasiController::class, 'edit']);
    Route::put('/wuspus-imun/{id}', [WuspusImunisasiController::class, 'update']);
    Route::delete('/wuspus-imun/{id}', [WuspusImunisasiController::class, 'destroy']);

    // Wuspus Kontrasepsi
    Route::get('/wuspus-kontrasepsi', [WuspusKontrasepsiController::class, 'index']);
    Route::get('/wuspus-kontrasepsi/create', [WuspusKontrasepsiController::class, 'create']);
    Route::post('/wuspus-kontrasepsi/store-multiple', [WuspusKontrasepsiController::class, 'storeMultiple']);
    Route::get('/wuspus-kontrasepsi/{id}', [WuspusKontrasepsiController::class, 'show']);
    Route::get('/wuspus-kontrasepsi/{id}/edit', [WuspusKontrasepsiController::class, 'edit']);
    Route::put('/wuspus-kontrasepsi/{id}', [WuspusKontrasepsiController::class, 'update']);
    Route::delete('/wuspus-kontrasepsi/{id}', [WuspusKontrasepsiController::class, 'destroy']);
    // WUSPUS Kematian
    Route::get('/wuspus-kematian', [WuspusKematianController::class, 'index']);
    Route::get('/wuspus-kematian/create', [WuspusKematianController::class, 'create']);
    Route::post('/wuspus-kematian/store-multiple', [WuspusKematianController::class, 'storeMultiple']);
    Route::get('/wuspus-kematian/{id}', [WuspusKematianController::class, 'show']);
    Route::get('/wuspus-kematian/{id}/edit', [WuspusKematianController::class, 'edit']);
    Route::put('/wuspus-kematian/{id}', [WuspusKematianController::class, 'update']);
    Route::delete('/wuspus-kematian/{id}', [WuspusKematianController::class, 'destroy']);


    // Ibu Hamil
    // Ibu Hamil Biodata
        Route::get('/bumil', [BumilBiodataController::class, 'index']);
        Route::get('/bumil/create', [BumilBiodataController::class, 'create']);
        Route::post('/bumil/store-multiple', [BumilBiodataController::class, 'storeMultiple']);
        Route::get('/bumil/{id}', [BumilBiodataController::class, 'show']);
        Route::get('/bumil/{id}/edit', [BumilBiodataController::class, 'edit']);
        Route::put('/bumil/{id}', [BumilBiodataController::class, 'update']);
        Route::delete('/bumil/{id}', [BumilBiodataController::class, 'destroy']);

    // Ibu Hamil Imunisasi
        Route::get('/bumil-imun', [BumilImunisasiController::class, 'index']);
        Route::get('/bumil-imun/create', [BumilImunisasiController::class, 'create']);
        Route::post('/bumil-imun/store-multiple', [BumilImunisasiController::class, 'storeMultiple']);
        Route::get('/bumil-imun/{id}', [BumilImunisasiController::class, 'show']);
        Route::get('/bumil-imun/{id}/edit', [BumilImunisasiController::class, 'edit']);
        Route::put('/bumil-imun/{id}', [BumilImunisasiController::class, 'update']);
        Route::delete('/bumil-imun/{id}', [BumilImunisasiController::class, 'destroy']);

    // Ibu Hamil Penimbangan
        Route::get('/bumil-pnb', [BumilPenimbanganController::class, 'index']);
        Route::get('/bumil-pnb/create', [BumilPenimbanganController::class, 'create']);
        Route::post('/bumil-pnb/store-multiple', [BumilPenimbanganController::class, 'storeMultiple']);
        Route::get('/bumil-pnb/{id}', [BumilPenimbanganController::class, 'show']);
        Route::get('/bumil-pnb/{id}/edit', [BumilPenimbanganController::class, 'edit']);
        Route::put('/bumil-pnb/{id}', [BumilPenimbanganController::class, 'update']);
        Route::delete('/bumil-pnb/{id}', [BumilPenimbanganController::class, 'destroy']);
    });


    // REKAP
    Route::get('/rekapitulasi', [RekapitulasiController::class, 'showRekapitulasiView'])
        ->name('rekapitulasi');
    
    // Operator
    Route::middleware('role:superadmin')->group(function () {

        Route::get('/operator', [OperatorController::class, 'index']);
        Route::get('/operator/create', [OperatorController::class, 'create']);
        Route::post('/operator', [OperatorController::class, 'store']);
        Route::get('/operator/{id}', [OperatorController::class, 'show']);
        Route::get('/operator/{id}/edit', [OperatorController::class, 'edit']);
        Route::put('/operator/{id}', [OperatorController::class, 'update']);
        Route::delete('/operator/{id}', [OperatorController::class, 'destroy']);

    });

    // SIPINTAR - CHATBOT
    Route::get('/sipintar/chatbot', [SipintarChatbotController::class, 'index'])
        ->name('sipintar.chatbot');

    Route::post('/sipintar/chatbot/api', [SipintarChatbotController::class, 'handle'])
        ->name('sipintar.chatbot.api');

    // SIPINTAR - STUNTING
     Route::get('/sipintar/stunting', [SipintarStuntingController::class, 'index'])
        ->name('sipintar.stunting');

    Route::post('/sipintar/stunting/analisis/{id_bayi}', 
        [SipintarStuntingController::class, 'analisis']
    );

    Route::post('/ai/stunting/predict-all', 
        [AiStuntingPredictController::class, 'predictForAll']
    )->name('ai.stunting.predictAll');

});

