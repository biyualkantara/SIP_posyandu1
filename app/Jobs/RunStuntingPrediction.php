<?php

namespace App\Jobs;

use App\Models\Bayi;
use App\Services\StuntingPredictor;

class RunStuntingPrediction extends Job
{
    protected $bayi;

    public function __construct(Bayi $bayi)
    {
        $this->bayi = $bayi;
    }

    public function handle()
    {
        app(StuntingPredictor::class)->runForBayi($this->bayi);
    }
}