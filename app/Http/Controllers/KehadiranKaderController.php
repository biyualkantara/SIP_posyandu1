<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class KehadiranKaderController extends Controller
{
    public function index(Request $request)
    {
        $kec = $request->get('kec', '');
        $kel = $request->get('kel', '');
        $bln = $request->get('bln', ''); // YYYY-MM
        $q   = $request->get('q', '');

        $kecamatan = DB::table('kcmtn')->orderBy('nama_kec')->get();

        $kelurahan = DB::table('klrhn')
            ->select('id_kel', 'id_kec', 'nama_kel')
            ->orderBy('nama_kel')
            ->get()
            ->groupBy('id_kec');

       $query = DB::table('kdrhdr as k')
        ->select([
            'k.id_kdrhdr',
            'k.id_posyandu',
            DB::raw('`k`.`bulan` as bulan_tahun'),
            'k.pkk',
            'k.plkb',
            'k.medis',
            'd.nama_posyandu',
            'kel.id_kel',
            'kel.nama_kel',
            'kec.id_kec',
            'kec.nama_kec'
        ])
        ->leftJoin('duspy as d','d.id_posyandu','=','k.id_posyandu')
        ->leftJoin('klrhn as kel','kel.id_kel','=','d.id_kel')
        ->leftJoin('kcmtn as kec','kec.id_kec','=','kel.id_kec')
        ->orderByDesc(DB::raw('`k`.`bulan`'))
        ->orderByDesc('k.id_kdrhdr');

       if (!empty($kec)) {
            $query->where('kec.id_kec', $kec);
        }

        if (!empty($kel)) {
            $query->where('kel.id_kel', $kel);
        }

        if (!empty($q)) {
            $query->where(function ($qq) use ($q) {
                $qq->where('d.nama_posyandu', 'like', "%{$q}%");
            });
        }

        if (!empty($bln)) {
            $query->whereRaw('DATE_FORMAT(k.bulan, "%Y-%m") = ?', [$bln]);
        }

        $data = $query->paginate(10)->withQueryString();

        return Inertia::render('posyandu/KehadiranKader/Index', [
            'data' => $data,
            'kecamatan' => $kecamatan,
            'kelurahanGrouped' => $kelurahan,
            'filter' => [
                'kec' => $kec,
                'kel' => $kel,
                'bln' => $bln,
                'q'   => $q,
            ],
        ]);
    }

    public function create()
    {
        $kecamatan = DB::table('kcmtn')->orderBy('nama_kec')->get();

        $kelurahan = DB::table('klrhn')
            ->select('id_kel', 'id_kec', 'nama_kel')
            ->orderBy('nama_kel')
            ->get()
            ->groupBy('id_kec');

        // posyandu per kelurahan (buat dropdown di Create/Edit)
        $posyandu = DB::table('duspy')
            ->select('id_posyandu', 'id_kel', 'nama_posyandu')
            ->orderBy('nama_posyandu')
            ->get()
            ->groupBy('id_kel');

        return Inertia::render('posyandu/KehadiranKader/Create', [
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'posyandu'  => $posyandu,
        ]);
    }

    public function storeMultiple(Request $request)
    {
        $request->validate([
            'kecamatan_id' => ['nullable'],
            'kelurahan_id' => ['required'],
            'rows' => ['required', 'array', 'min:1'],
            'rows.*.id_posyandu' => ['required'],
            'rows.*.bulan' => ['required'], // YYYY-MM
            'rows.*.pkk' => ['required'],
            'rows.*.plkb' => ['required'],
            'rows.*.medis' => ['required'],
        ]);

        $rows = $request->input('rows', []);

        DB::beginTransaction();
        try {
            foreach ($rows as $r) {
                $bulan = $r['bulan'] . '-01'; // simpan DATE awal bulan ke kolom `bulan/tahun`
                DB::table('kdrhdr')->insert([
                    'id_posyandu' => $r['id_posyandu'],
                    'bulan' => $bulan,
                    'pkk' => (int)$r['pkk'],
                    'plkb' => (int)$r['plkb'],
                    'medis' => (int)$r['medis'],
                ]);
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect('/posyandu/kehadiran-kader');
    }

    public function show($id)
    {
        $kdr = DB::table('kdrhdr as k')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'k.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->select([
                'k.id_kdrhdr',
                DB::raw('k.`bulan` as bulan_tahun'),
                'k.pkk', 'k.plkb', 'k.medis',
                'd.id_posyandu', 'd.nama_posyandu',
                'kel.nama_kel',
                'kec.nama_kec',
            ])
            ->where('k.id_kdrhdr', $id)
            ->first();

        abort_if(!$kdr, 404);

        return Inertia::render('posyandu/KehadiranKader/Show', [
            'kdrhdr' => $kdr,
        ]);
    }

    public function edit($id)
    {
        $kecamatan = DB::table('kcmtn')->orderBy('nama_kec')->get();

        $kelurahan = DB::table('klrhn')
            ->select('id_kel', 'id_kec', 'nama_kel')
            ->orderBy('nama_kel')
            ->get()
            ->groupBy('id_kec');

        $posyandu = DB::table('duspy')
            ->select('id_posyandu', 'id_kel', 'nama_posyandu')
            ->orderBy('nama_posyandu')
            ->get()
            ->groupBy('id_kel');

        $kdr = DB::table('kdrhdr as k')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'k.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->select([
                'k.id_kdrhdr',
                'k.id_posyandu',
                DB::raw('DATE_FORMAT(k.`bulan`, "%Y-%m") as bulan'),
                'k.pkk', 'k.plkb', 'k.medis',
                'kel.id_kel',
                'kel.nama_kel',
                'kec.id_kec',
                'kec.nama_kec',
            ])
            ->where('k.id_kdrhdr', $id)
            ->first();

        abort_if(!$kdr, 404);

        return Inertia::render('posyandu/KehadiranKader/Edit', [
            'kdrhdr' => $kdr,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'posyandu'  => $posyandu,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_posyandu' => ['required'],
            'bulan' => ['required'], // YYYY-MM
            'pkk' => ['required'],
            'plkb' => ['required'],
            'medis' => ['required'],
        ]);

        $bulan = $request->bulan . '-01';

        DB::table('kdrhdr')
            ->where('id_kdrhdr', $id)
            ->update([
                'id_posyandu' => $request->id_posyandu,
                'bulan' => $bulan,
                'pkk' => (int)$request->pkk,
                'plkb' => (int)$request->plkb,
                'medis' => (int)$request->medis,
            ]);

        return redirect('/posyandu/kehadiran-kader');
    }

    public function destroy($id)
    {
        DB::table('kdrhdr')->where('id_kdrhdr', $id)->delete();
        return redirect('/posyandu/kehadiran-kader');
    }
}