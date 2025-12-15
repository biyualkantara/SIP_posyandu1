<?php

namespace App\Observers;

use App\Models\Bayi;
use App\Services\StuntingAiService;

class BayiObserver
{
    public function created(Bayi $bayi)
    {
        StuntingAiService::predict($bayi);
    }

    public function updated(Bayi $bayi)
    {
        StuntingAiService::predict($bayi);
    }
}