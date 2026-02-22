<?php

namespace App\Http\Controllers;

use App\Exports\Format1Export;
use App\Exports\Format2Export;
use App\Exports\Format3Export;
use App\Exports\Format4Export;
use App\Exports\Format5Export;
use App\Models\Duspy;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Wuspus;
use Excel;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function exportFormat(Request $request, $format) {
        $kecamatan = Kecamatan::find($request->query('id_kecamatan'));
        $kelurahan = Kelurahan::find($request->query('id_kelurahan'));
        $posyandu = Duspy::find($request->query('id_posyandu'));
        $tahun = $request->query('tahun') === 'All' ? '' : $request->query('tahun');
        
        if($format === 'f1') {
            return Pdf::loadView('rekapitulasi.format_1', [
                'kecamatan' => $kecamatan->nama_kec ?? '',
                'kelurahan' => $kelurahan->nama_kel ?? '',
                'posyandu' => $posyandu->nama_posyandu ?? '',
                'tahun' => $tahun ?? ''
            ])
            ->setPaper('a4', 'landscape')
            ->download('rekapitulasi_format1.pdf');

            // return Excel::download(
            //     new Format1Export(
            //         $kecamatan->nama_kec ?? '',
            //         $kelurahan->nama_kel ?? '',
            //         $posyandu->nama_posyandu ?? '',
            //         $tahun ?? ''
            //     ),
            //     'format1.xlsx'
            // );
        } else if($format === 'f2') {
            return Pdf::loadView('rekapitulasi.format_2', [
                'kecamatan' => $kecamatan->nama_kec ?? '',
                'kelurahan' => $kelurahan->nama_kel ?? '',
                'posyandu' => $posyandu->nama_posyandu ?? '',
                'tahun' => $tahun ?? ''
            ])
            ->setPaper('a4', 'landscape')
            ->download('rekapitulasi_format2.pdf');

            // return Excel::download(
            //     new Format2Export(
            //         $kecamatan->nama_kec ?? '',
            //         $kelurahan->nama_kel ?? '',
            //         $posyandu->nama_posyandu ?? '',
            //         $tahun ?? ''
            //     ),
            //     'format2.xlsx'
            // );
        } else if($format === 'f3') {
            return Pdf::loadView('rekapitulasi.format_3', [
                'kecamatan' => $kecamatan->nama_kec ?? '',
                'kelurahan' => $kelurahan->nama_kel ?? '',
                'posyandu' => $posyandu->nama_posyandu ?? '',
                'tahun' => $tahun ?? ''
            ])
            ->setPaper('a4', 'landscape')
            ->download('rekapitulasi_format3.pdf');

            // return Excel::download(
            //     new Format3Export(
            //         $kecamatan->nama_kec ?? '',
            //         $kelurahan->nama_kel ?? '',
            //         $posyandu->nama_posyandu ?? '',
            //         $tahun ?? ''
            //     ),
            //     'format3.xlsx'
            // );
        } else if($format === 'f4') {
            return Pdf::loadView('rekapitulasi.format_4', [
                'kecamatan' => $kecamatan->nama_kec ?? '',
                'kelurahan' => $kelurahan->nama_kel ?? '',
                'posyandu' => $posyandu->nama_posyandu ?? '',
                'tahun' => $tahun ?? ''
            ])
            ->setPaper('a4', 'landscape')
            ->download('rekapitulasi_format4.pdf');

            // return Excel::download(
            //     new Format4Export(
            //         $kecamatan->nama_kec ?? '',
            //         $kelurahan->nama_kel ?? '',
            //         $posyandu->nama_posyandu ?? '',
            //         $tahun ?? ''
            //     ),
            //     'format4.xlsx'
            // );
        } else if($format === 'f5') {
            return Pdf::loadView('rekapitulasi.format_5', [
                'kecamatan' => $kecamatan->nama_kec ?? '',
                'kelurahan' => $kelurahan->nama_kel ?? '',
                'posyandu' => $posyandu->nama_posyandu ?? '',
                'tahun' => $tahun ?? ''
            ])
            ->setPaper('a4', 'landscape')
            ->download('rekapitulasi_format5.pdf');

            // return Excel::download(
            //     new Format5Export(
            //         $kecamatan->nama_kec ?? '',
            //         $kelurahan->nama_kel ?? '',
            //         $posyandu->nama_posyandu ?? '',
            //         $tahun ?? ''
            //     ),
            //     'format5.xlsx'
            // );
        } else if($format === 'f6') {
            return Pdf::loadView('rekapitulasi.format_6', [
                'kecamatan' => $kecamatan->nama_kec ?? '',
                'kelurahan' => $kelurahan->nama_kel ?? '',
                'posyandu' => $posyandu->nama_posyandu ?? '',
                'tahun' => $tahun ?? ''
            ])
            ->setPaper('a4', 'landscape')
            ->download('rekapitulasi_format6.pdf');

            // return Excel::download(
            //     new Format6Export(
            //         $kecamatan->nama_kec ?? '',
            //         $kelurahan->nama_kel ?? '',
            //         $posyandu->nama_posyandu ?? '',
            //         $tahun ?? ''
            //     ),
            //     'format6.xlsx'
            // );
        }
        
        return back();
    }
}
