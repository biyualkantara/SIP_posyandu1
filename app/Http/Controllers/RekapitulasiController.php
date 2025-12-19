<?php

namespace App\Http\Controllers;

use App\Models\Duspy;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Wuspus;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RekapitulasiController extends Controller
{
    public function showRekapitulasiView() {
        return Inertia::render("rekapitulasi/Rekapitulasi", [
            "kecamatan" => Kecamatan::all(),
            "kelurahan" => Kelurahan::all()->groupBy('id_kec'),
            "posyandu" => Duspy::all()->groupBy("id_kel"),
            "wuspus" => Wuspus::all()->groupBy("id_posyandu"),
        ]);
    }

    public function exportFormat($format) {
        // Logic to export rekapitulasi data in the specified format (e.g., PDF, Excel)

        // return back
        return back();
    }
}