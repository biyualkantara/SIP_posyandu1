<?php

namespace App\Observers;

use App\Models\Wuspus;
use App\Services\StuntingAiService;

class WuspusObserver
{
    public function updated(Wuspus $wuspus)
    {
        // Ambil semua bayi dari ortu ini
        $bayiList = $wuspus->bayi()->get();

        foreach ($bayiList as $b) {
            StuntingAiService::predict($b);
        }
    }
}