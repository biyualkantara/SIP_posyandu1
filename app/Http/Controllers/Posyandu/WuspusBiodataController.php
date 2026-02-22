<?php

namespace App\Http\Controllers\Posyandu;

use App\Http\Controllers\Controller;
use App\Models\Wuspus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class WuspusBiodataController extends Controller
{
    public function index(Request $request)
    {
        $kec = $request->get('kec', '');
        $kel = $request->get('kel', '');
        $pos = $request->get('pos', '');
        $q   = $request->get('q', '');

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

        $query = DB::table('wuspus as w')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kelx', 'kelx.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kecx', 'kecx.id_kec', '=', 'kelx.id_kec')
            ->select([
                'w.id_wuspus',
                'w.id_posyandu',
                'w.nik_wuspus',
                'w.nama_wuspus',
                'w.umur',
                'w.tinggi_ibu',
                'w.nama_suami',
                'w.tinggi_ayah',
                'w.thpn_ks',
                'w.klmpk_dasawisma',
                'w.jml_anak_hdp',
                'w.jml_anak_meninggal',
                'w.tgl_daftar',
                'w.status',
                'w.ket',

                'd.nama_posyandu',
                'kelx.id_kel',
                'kelx.nama_kel',
                'kecx.id_kec',
                'kecx.nama_kec',
            ])
            ->orderBy('w.nama_wuspus');

        if ($kec !== '') $query->where('kecx.id_kec', $kec);
        if ($kel !== '') $query->where('kelx.id_kel', $kel);
        if ($pos !== '') $query->where('d.id_posyandu', $pos);

        if ($q !== '') {
            $query->where(function ($x) use ($q) {
                $x->where('w.nama_wuspus', 'like', "%{$q}%")
                  ->orWhere('w.nik_wuspus', 'like', "%{$q}%")
                  ->orWhere('w.nama_suami', 'like', "%{$q}%")
                  ->orWhere('w.status', 'like', "%{$q}%")
                  ->orWhere('d.nama_posyandu', 'like', "%{$q}%");
            });
        }

        $data = $query->paginate(20)->withQueryString();

        return Inertia::render('wuspus/biodata/Index', [
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

        return Inertia::render('wuspus/biodata/Create', [
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'posyandu' => $posyandu,
        ]);
    }

    public function storeMultiple(Request $request)
    {
        $request->validate([
            'kecamatan_id' => ['nullable'],
            'kelurahan_id' => ['required'],
            'posyandu_id'  => ['required', 'integer', 'exists:duspy,id_posyandu'],

            'rows' => ['required', 'array', 'min:1'],

            'rows.*.nik_wuspus' => ['required', 'string', 'max:20'],
            'rows.*.nama_wuspus' => ['required', 'string', 'max:120'],

            'rows.*.umur' => ['nullable', 'integer'],
            'rows.*.tinggi_ibu' => ['nullable', 'integer'],
            'rows.*.nama_suami' => ['nullable', 'string', 'max:120'],
            'rows.*.tinggi_ayah' => ['nullable', 'integer'],
            'rows.*.thpn_ks' => ['nullable', 'string', 'max:50'],
            'rows.*.klmpk_dasawisma' => ['nullable', 'string', 'max:120'],
            'rows.*.jml_anak_hdp' => ['nullable', 'integer'],
            'rows.*.jml_anak_meninggal' => ['nullable', 'integer'],

            'rows.*.tgl_daftar' => ['nullable', 'date'],
            'rows.*.status' => ['nullable', 'string', 'max:50'],
            'rows.*.ket' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->input('rows', []) as $r) {
                DB::table('wuspus')->insert([
                    'id_posyandu' => (int) $request->posyandu_id,
                    'nik_wuspus' => $r['nik_wuspus'],
                    'nama_wuspus' => $r['nama_wuspus'],
                    'umur' => $r['umur'] ?? null,
                    'tinggi_ibu' => $r['tinggi_ibu'] ?? null,
                    'nama_suami' => $r['nama_suami'] ?? null,
                    'tinggi_ayah' => $r['tinggi_ayah'] ?? null,
                    'thpn_ks' => $r['thpn_ks'] ?? null,
                    'klmpk_dasawisma' => $r['klmpk_dasawisma'] ?? null,
                    'jml_anak_hdp' => $r['jml_anak_hdp'] ?? null,
                    'jml_anak_meninggal' => $r['jml_anak_meninggal'] ?? null,
                    'tgl_daftar' => $r['tgl_daftar'] ?? null,
                    'status' => $r['status'] ?? null,
                    'ket' => $r['ket'] ?? null,
                ]);
            }
        });

        return redirect('/posyandu/wuspus')->with('success', 'Data biodata WUS/PUS berhasil disimpan');
    }

    public function show($id)
    {
        $row = DB::table('wuspus as w')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kelx', 'kelx.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kecx', 'kecx.id_kec', '=', 'kelx.id_kec')
            ->where('w.id_wuspus', $id)
            ->select([
                'w.*',
                'd.nama_posyandu',
                'kelx.nama_kel',
                'kecx.nama_kec',
            ])
            ->first();

        abort_if(!$row, 404);

        return Inertia::render('wuspus/biodata/Show', [
            'row' => $row,
        ]);
    }

    public function edit($id)
    {
        $row = Wuspus::findOrFail($id);

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

        // untuk set default kec/kel di edit
        $meta = DB::table('wuspus as w')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kelx', 'kelx.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kecx', 'kecx.id_kec', '=', 'kelx.id_kec')
            ->where('w.id_wuspus', $id)
            ->select([
                'd.id_posyandu',
                'kelx.id_kel',
                'kecx.id_kec',
            ])
            ->first();

        return Inertia::render('wuspus/biodata/Edit', [
            'row' => $row,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'posyandu' => $posyandu,
            'meta' => $meta,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_posyandu' => ['required', 'integer', 'exists:duspy,id_posyandu'],
            'nik_wuspus' => ['required', 'string', 'max:20'],
            'nama_wuspus' => ['required', 'string', 'max:120'],

            'umur' => ['nullable', 'integer'],
            'tinggi_ibu' => ['nullable', 'integer'],
            'nama_suami' => ['nullable', 'string', 'max:120'],
            'tinggi_ayah' => ['nullable', 'integer'],
            'thpn_ks' => ['nullable', 'string', 'max:50'],
            'klmpk_dasawisma' => ['nullable', 'string', 'max:120'],
            'jml_anak_hdp' => ['nullable', 'integer'],
            'jml_anak_meninggal' => ['nullable', 'integer'],
            'tgl_daftar' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'max:50'],
            'ket' => ['nullable', 'string'],
        ]);

        Wuspus::where('id_wuspus', $id)->update([
            'id_posyandu' => (int) $request->id_posyandu,
            'nik_wuspus' => $request->nik_wuspus,
            'nama_wuspus' => $request->nama_wuspus,
            'umur' => $request->umur,
            'tinggi_ibu' => $request->tinggi_ibu,
            'nama_suami' => $request->nama_suami,
            'tinggi_ayah' => $request->tinggi_ayah,
            'thpn_ks' => $request->thpn_ks,
            'klmpk_dasawisma' => $request->klmpk_dasawisma,
            'jml_anak_hdp' => $request->jml_anak_hdp,
            'jml_anak_meninggal' => $request->jml_anak_meninggal,
            'tgl_daftar' => $request->tgl_daftar,
            'status' => $request->status,
            'ket' => $request->ket,
        ]);

        return redirect('/posyandu/wuspus')->zwith('success', 'Data biodata WUS/PUS berhasil diperbarui');
    }

    public function destroy($id)
    {
        Wuspus::where('id_wuspus', $id)->delete();
        return redirect('/posyandu/wuspus')->with('success', 'Data biodata WUS/PUS berhasil dihapus');
    }
}