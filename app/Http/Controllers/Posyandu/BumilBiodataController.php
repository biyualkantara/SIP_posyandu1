<?php

namespace App\Http\Controllers\Posyandu;

use App\Http\Controllers\Controller;
use App\Models\Bumil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class BumilBiodataController extends Controller
{
    public function index(Request $request)
    {
        $kec = $request->get('kec', '');
        $kel = $request->get('kel', '');
        $pos = $request->get('pos', '');
        $q   = $request->get('q', '');

        // dropdown filter (kcmtn -> klrhn -> duspy)
        $kecamatan = DB::table('kcmtn')
            ->select('id_kec', 'nama_kec')
            ->orderBy('nama_kec')
            ->get();

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

        $query = DB::table('bumil as b')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->select([
                'b.id_bumil',
                'b.id_wuspus',
                'b.tgl_daftar',
                'b.umur_kehamilan',
                'b.hamil_ke',
                'b.pmt_pemulihan',
                'b.lila',
                'b.ket',
                'w.nik_wuspus',
                'w.nama_wuspus',
                'd.id_posyandu',
                'd.nama_posyandu',
                'kel.id_kel',
                'kel.nama_kel',
                'kec.id_kec',
                'kec.nama_kec',
            ])
            ->orderByDesc('b.id_bumil');

        if ($kec !== '') $query->where('kec.id_kec', $kec);
        if ($kel !== '') $query->where('kel.id_kel', $kel);
        if ($pos !== '') $query->where('d.id_posyandu', $pos);

        if ($q !== '') {
            $query->where(function ($x) use ($q) {
                $x->where('w.nama_wuspus', 'like', "%{$q}%")
                  ->orWhere('w.nik_wuspus', 'like', "%{$q}%")
                  ->orWhere('d.nama_posyandu', 'like', "%{$q}%");
            });
        }

        $data = $query->paginate(20)->withQueryString();

        return Inertia::render('bumil/biodata/Index', [
            'data' => $data,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'posyandu' => $posyandu,
            'filter' => [
                'kec' => $kec,
                'kel' => $kel,
                'pos' => $pos,
                'q'   => $q,
            ],
        ]);
    }

    public function create()
    {
        $kecamatan = DB::table('kcmtn')
            ->select('id_kec', 'nama_kec')
            ->orderBy('nama_kec')
            ->get();

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

        // WUS/PUS dikelompokkan per posyandu (karena bumil pilih id_wuspus)
        $wuspus = DB::table('wuspus')
            ->select('id_wuspus', 'id_posyandu', 'nik_wuspus', 'nama_wuspus')
            ->orderBy('nama_wuspus')
            ->get()
            ->groupBy('id_posyandu');

        return Inertia::render('bumil/biodata/Create', [
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'posyandu'  => $posyandu,
            'wuspus'    => $wuspus,
        ]);
    }

    public function storeMultiple(Request $request)
    {
        $request->validate([
            'kecamatan_id' => ['nullable'],
            'kelurahan_id' => ['required'],
            'posyandu_id'  => ['required'],
            'rows' => ['required', 'array', 'min:1'],

            'rows.*.id_wuspus' => ['required', 'integer', 'exists:wuspus,id_wuspus'],
            'rows.*.tgl_daftar' => ['nullable', 'date'],
            'rows.*.umur_kehamilan' => ['nullable', 'integer', 'min:0'],
            'rows.*.hamil_ke' => ['nullable', 'integer', 'min:0'],
            'rows.*.pmt_pemulihan' => ['nullable', 'string', 'max:100'],
            'rows.*.lila' => ['nullable', 'numeric'],
            'rows.*.ket' => ['nullable', 'string'],
        ]);

        $rows = $request->input('rows', []);

        DB::beginTransaction();
        try {
            foreach ($rows as $r) {
                DB::table('bumil')->insert([
                    'id_wuspus' => (int)($r['id_wuspus']),
                    'tgl_daftar' => $r['tgl_daftar'] ?? null,
                    'umur_kehamilan' => $r['umur_kehamilan'] !== '' ? (int)$r['umur_kehamilan'] : null,
                    'hamil_ke' => $r['hamil_ke'] !== '' ? (int)$r['hamil_ke'] : null,
                    'pmt_pemulihan' => $r['pmt_pemulihan'] ?? null,
                    'lila' => $r['lila'] !== '' ? (float)$r['lila'] : null,
                    'ket' => $r['ket'] ?? null,
                ]);
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect('/posyandu/bumil')->with('success', 'Data bumil berhasil disimpan');
    }

    public function show($id)
    {
        $row = DB::table('bumil as b')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->select([
                'b.*',
                'w.nik_wuspus',
                'w.nama_wuspus',
                'd.nama_posyandu',
                'kel.nama_kel',
                'kec.nama_kec',
            ])
            ->where('b.id_bumil', $id)
            ->first();

        abort_if(!$row, 404);

        return Inertia::render('bumil/biodata/Show', [
            'row' => $row
        ]);
    }

    public function edit($id)
    {
        $row = DB::table('bumil as b')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->select([
                'b.*',
                'w.id_posyandu',
                'w.nik_wuspus',
                'w.nama_wuspus',
                'd.id_kel',
                'kel.id_kec',
                'kec.nama_kec',
                'kel.nama_kel',
                'd.nama_posyandu',
            ])
            ->where('b.id_bumil', $id)
            ->first();

        abort_if(!$row, 404);

        $kecamatan = DB::table('kcmtn')->select('id_kec', 'nama_kec')->orderBy('nama_kec')->get();
        $kelurahan = DB::table('klrhn')->select('id_kel', 'id_kec', 'nama_kel')->orderBy('nama_kel')->get()->groupBy('id_kec');
        $posyandu  = DB::table('duspy')->select('id_posyandu', 'id_kel', 'nama_posyandu')->orderBy('nama_posyandu')->get()->groupBy('id_kel');
        $wuspus    = DB::table('wuspus')->select('id_wuspus', 'id_posyandu', 'nik_wuspus', 'nama_wuspus')->orderBy('nama_wuspus')->get()->groupBy('id_posyandu');

        return Inertia::render('bumil/biodata/Edit', [
            'row' => $row,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'posyandu'  => $posyandu,
            'wuspus'    => $wuspus,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_wuspus' => ['required', 'integer', 'exists:wuspus,id_wuspus'],
            'tgl_daftar' => ['nullable', 'date'],
            'umur_kehamilan' => ['nullable', 'integer', 'min:0'],
            'hamil_ke' => ['nullable', 'integer', 'min:0'],
            'pmt_pemulihan' => ['nullable', 'string', 'max:100'],
            'lila' => ['nullable', 'numeric'],
            'ket' => ['nullable', 'string'],
        ]);

        Bumil::where('id_bumil', $id)->update([
            'id_wuspus' => (int)$request->id_wuspus,
            'tgl_daftar' => $request->tgl_daftar,
            'umur_kehamilan' => $request->umur_kehamilan !== '' ? (int)$request->umur_kehamilan : null,
            'hamil_ke' => $request->hamil_ke !== '' ? (int)$request->hamil_ke : null,
            'pmt_pemulihan' => $request->pmt_pemulihan,
            'lila' => $request->lila !== '' ? (float)$request->lila : null,
            'ket' => $request->ket,
        ]);

        return redirect('/posyandu/bumil')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        Bumil::where('id_bumil', $id)->delete();
        return redirect('/posyandu/bumil')->with('success', 'Data berhasil dihapus');
    }
}