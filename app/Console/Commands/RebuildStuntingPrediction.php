<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Bayi;
use App\Services\StuntingPredictor;
use Illuminate\Support\Facades\DB;

class RebuildStuntingPrediction extends Command
{
    protected $signature = 'stunting:rebuild';
    protected $description = 'Hitung ulang semua prediksi stunting untuk seluruh data bayi';

    public function handle()
    {
        $this->info("Menghapus data prediksi lama...");
        DB::table('ai_stunting_prediction')->truncate();

        $this->info("Mengambil seluruh bayi...");
        $bayis = Bayi::with('wuspus')->get();

        $predict = app(StuntingPredictor::class);

        $this->info("Mulai membuat prediksi...");

        foreach ($bayis as $bayi) {
            $predict->runForBayi($bayi);
            $this->line("✔ Prediksi: {$bayi->nama_bayi}");
        }

        $this->info("Semua prediksi selesai dibuat ulang.");

        return Command::SUCCESS;
    }
}