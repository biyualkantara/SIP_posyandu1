<?php

namespace App\Http\Controllers\Posyandu;

use App\Http\Controllers\Controller;
use App\Models\WuspusImunisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class WuspusImunisasiController extends Controller
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

        $query = DB::table('wuspus_imun as wi')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'wi.id_wuspus')
            ->leftJoin('imunisasi as i', 'i.id_imun', '=', 'wi.id_imun')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->select([
                'wi.id_wuspus_imun',
                'wi.id_wuspus',
                'wi.id_imun',
                'wi.tgl_imun',
                'wi.ket',

                'w.nik_wuspus',
                'w.nama_wuspus',

                'i.jns_imun',

                'd.id_posyandu',
                'd.nama_posyandu',

                'kel.id_kel',
                'kel.nama_kel',

                'kec.id_kec',
                'kec.nama_kec',
            ])
            ->orderByDesc('wi.tgl_imun')
            ->orderByDesc('wi.id_wuspus_imun');

        if (!empty($kec)) {
            $query->where('kec.id_kec', $kec);
        }

        if (!empty($kel)) {
            $query->where('kel.id_kel', $kel);
        }

        if (!empty($pos)) {
            $query->where('d.id_posyandu', $pos);
        }

        if ($q !== '') {
            $query->where(function ($x) use ($q) {
                $x->where('w.nama_wuspus', 'like', "%{$q}%")
                  ->orWhere('w.nik_wuspus', 'like', "%{$q}%")
                  ->orWhere('d.nama_posyandu', 'like', "%{$q}%")
                  ->orWhere('i.jns_imun', 'like', "%{$q}%");
            });
        }

        $data = $query->paginate(20)->withQueryString();

        return Inertia::render('wuspus/imunisasi/Index', [
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

        // WUS/PUS dikelompokkan per posyandu
        $wuspus = DB::table('wuspus')
            ->select('id_wuspus', 'id_posyandu', 'nik_wuspus', 'nama_wuspus')
            ->orderBy('nama_wuspus')
            ->get()
            ->groupBy('id_posyandu');

        $imun = DB::table('imunisasi')
            ->select('id_imun', 'jns_imun')
            ->orderBy('jns_imun')
            ->get();

        return Inertia::render('wuspus/imunisasi/Create', [
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'posyandu'  => $posyandu,
            'wuspus'    => $wuspus,
            'imun'      => $imun,
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
            'rows.*.id_imun'   => ['required', 'integer', 'exists:imunisasi,id_imun'],
            'rows.*.tgl_imun'  => ['required', 'date'],
            'rows.*.ket'       => ['nullable', 'string'],
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->input('rows', []) as $r) {
                DB::table('wuspus_imun')->insert([
                    'id_wuspus' => (int)$r['id_wuspus'],
                    'id_imun'   => (int)$r['id_imun'],
                    'tgl_imun'  => $r['tgl_imun'],
                    'ket'       => $r['ket'] ?? null,
                ]);
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect('/posyandu/wuspus-imun')->with('success', 'Data imunisasi WUS/PUS berhasil disimpan');
    }

    public function show($id)
    {
        $row = DB::table('wuspus_imun as wi')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'wi.id_wuspus')
            ->leftJoin('imunisasi as i', 'i.id_imun', '=', 'wi.id_imun')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->where('wi.id_wuspus_imun', $id)
            ->select([
                'wi.*',
                'w.nik_wuspus',
                'w.nama_wuspus',
                'i.jns_imun',
                'd.nama_posyandu',
                'kel.nama_kel',
                'kec.nama_kec',
            ])
            ->first();

        abort_if(!$row, 404);

        return Inertia::render('wuspus/imunisasi/Show', ['row' => $row]);
    }

    public function edit($id)
    {
        $row = WuspusImunisasi::findOrFail($id);

        $wuspus = DB::table('wuspus')
            ->select('id_wuspus', 'nik_wuspus', 'nama_wuspus')
            ->orderBy('nama_wuspus')
            ->get();

        $imun = DB::table('imunisasi')
            ->select('id_imun', 'jns_imun')
            ->orderBy('jns_imun')
            ->get();

        return Inertia::render('wuspus/imunisasi/Edit', [
            'row' => $row,
            'wuspus' => $wuspus,
            'imun' => $imun,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_wuspus' => ['required', 'integer', 'exists:wuspus,id_wuspus'],
            'id_imun'   => ['required', 'integer', 'exists:imunisasi,id_imun'],
            'tgl_imun'  => ['required', 'date'],
            'ket'       => ['nullable', 'string'],
        ]);

        WuspusImunisasi::where('id_wuspus_imun', $id)->update([
            'id_wuspus' => (int)$request->id_wuspus,
            'id_imun'   => (int)$request->id_imun,
            'tgl_imun'  => $request->tgl_imun,
            'ket'       => $request->ket,
        ]);

        return redirect('/posyandu/wuspus-imun')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        WuspusImunisasi::where('id_wuspus_imun', $id)->delete();
        return redirect('/posyandu/wuspus-imun')->with('success', 'Data berhasil dihapus');
    }
}