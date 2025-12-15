<?php

use Illuminate\Support\Facades\Route;

// Controller asli
use App\Http\Controllers\DuspyController;
use App\Http\Controllers\KaderKehadiranController;
use App\Http\Controllers\BayiController;
use App\Http\Controllers\Api\SipintarChatbotController;

/*
|--------------------------------------------------------------------------
| API DUSPY - Data Umum Posyandu
|--------------------------------------------------------------------------
*/
Route::apiResource('duspy', DuspyController::class);

Route::get('/duspy-export/excel', [DuspyController::class, 'exportExcel']);
Route::get('/duspy-export/pdf', [DuspyController::class, 'exportPdf']);
Route::get('/duspy/{id}/print', [DuspyController::class, 'printSingle']);


/*
|--------------------------------------------------------------------------
| API BAYI - Biodata, Penimbangan, Imunisasi, Kematian
|--------------------------------------------------------------------------
*/
Route::prefix('bayi')->group(function () {

    // Biodata
    Route::get('/biodata', [BayiController::class, 'getBiodata']);
    Route::post('/biodata', [BayiController::class, 'postBiodata']);
    Route::put('/biodata/{id}', [BayiController::class, 'updateBiodata']);
    Route::delete('/biodata/{id}', [BayiController::class, 'deleteBiodata']);

    // Penimbangan
    Route::get('/penimbangan', [BayiController::class, 'getPenimbangan']);

    // Imunisasi
    Route::get('/imunisasi', [BayiController::class, 'getImunisasi']);

    // Kematian
    Route::get('/kematian', [BayiController::class, 'getKematian']);
});