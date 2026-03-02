<?php

namespace App\Http\Controllers\Posyandu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\BumilImunisasi;

class BumilImunisasiController extends Controller
{
    public function index(Request $request)
    {
        // filter mengikuti pola biodata (kec, kel, pos, q)
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

        // data utama
        $query = DB::table('bumil_imun as bi')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'bi.id_wuspus')
            ->leftJoin('imunisasi as i', 'i.id_imun', '=', 'bi.id_imun')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->select([
                'bi.id_bumil_imun',
                'bi.id_wuspus',
                'bi.id_imun',
                'bi.tgl_imun',
                'bi.ket',

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
            ->orderByDesc('bi.tgl_imun')
            ->orderByDesc('bi.id_bumil_imun');

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
                  ->orWhere('i.jns_imun', 'like', "%{$q}%")
                  ->orWhere('d.nama_posyandu', 'like', "%{$q}%");
            });
        }

        $data = $query->paginate(20)->withQueryString();

        return Inertia::render('bumil/imunisasi/Index', [
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

        // WUS/PUS dikelompokkan per posyandu (ikut panutan biodata)
        $wuspus = DB::table('wuspus')
            ->select('id_wuspus', 'id_posyandu', 'nik_wuspus', 'nama_wuspus')
            ->orderBy('nama_wuspus')
            ->get()
            ->groupBy('id_posyandu');

        $imun = DB::table('imunisasi')
            ->select('id_imun', 'jns_imun')
            ->orderBy('jns_imun')
            ->get();

        return Inertia::render('bumil/imunisasi/Create', [
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

        $rows = $request->input('rows', []);

        DB::beginTransaction();
        try {
            foreach ($rows as $r) {
                DB::table('bumil_imun')->insert([
                    'id_wuspus' => (int)($r['id_wuspus']),
                    'id_imun'   => (int)($r['id_imun']),
                    'tgl_imun'  => $r['tgl_imun'],
                    'ket'       => $r['ket'] ?? null,
                ]);
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect('/posyandu/bumil-imun')->with('success', 'Data imunisasi bumil berhasil disimpan');
    }

    public function show($id)
    {
        $row = DB::table('bumil_imun as bi')
            ->leftJoin('wuspus as w','w.id_wuspus','=','bi.id_wuspus')
            ->leftJoin('imunisasi as i','i.id_imun','=','bi.id_imun')
            ->leftJoin('duspy as d','d.id_posyandu','=','w.id_posyandu')
            ->leftJoin('klrhn as kel','kel.id_kel','=','d.id_kel')
            ->leftJoin('kcmtn as kec','kec.id_kec','=','kel.id_kec')
            ->where('bi.id_bumil_imun',$id)
            ->select([
                'bi.*',
                'w.nik_wuspus',
                'w.nama_wuspus',
                'i.jns_imun',
                'd.nama_posyandu',
                'kel.nama_kel',
                'kec.nama_kec',
            ])
            ->first();

        abort_if(!$row,404);

        return Inertia::render('bumil/imunisasi/Show', ['row'=>$row]);
    }

    public function edit($id)
    {
        $row = DB::table('bumil_imun as bi')
            ->leftJoin('wuspus as w','w.id_wuspus','=','bi.id_wuspus')
            ->leftJoin('duspy as d','d.id_posyandu','=','w.id_posyandu')
            ->leftJoin('klrhn as kel','kel.id_kel','=','d.id_kel')
            ->leftJoin('kcmtn as kec','kec.id_kec','=','kel.id_kec')
            ->select([
                'bi.*',
                'w.id_posyandu',
                'w.nik_wuspus',
                'w.nama_wuspus',
                'd.id_kel',
                'kel.id_kec',
                'kec.nama_kec',
                'kel.nama_kel',
                'd.nama_posyandu',
            ])
            ->where('bi.id_bumil_imun', $id)
            ->first();

        abort_if(!$row, 404);

        $kecamatan = DB::table('kcmtn')->select('id_kec', 'nama_kec')->orderBy('nama_kec')->get();
        $kelurahan = DB::table('klrhn')->select('id_kel', 'id_kec', 'nama_kel')->orderBy('nama_kel')->get()->groupBy('id_kec');
        $posyandu  = DB::table('duspy')->select('id_posyandu', 'id_kel', 'nama_posyandu')->orderBy('nama_posyandu')->get()->groupBy('id_kel');
        $wuspus    = DB::table('wuspus')->select('id_wuspus', 'id_posyandu', 'nik_wuspus', 'nama_wuspus')->orderBy('nama_wuspus')->get()->groupBy('id_posyandu');
        $imun      = DB::table('imunisasi')->select('id_imun','jns_imun')->orderBy('jns_imun')->get();

        return Inertia::render('bumil/imunisasi/Edit', [
            'row' => $row,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'posyandu'  => $posyandu,
            'wuspus'    => $wuspus,
            'imun'      => $imun,
        ]);
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'id_wuspus' => ['required','integer','exists:wuspus,id_wuspus'],
            'id_imun'   => ['required','integer','exists:imunisasi,id_imun'],
            'tgl_imun'  => ['required','date'],
            'ket'       => ['nullable','string'],
        ]);

        BumilImunisasi::where('id_bumil_imun',$id)->update([
            'id_wuspus' => (int)$request->id_wuspus,
            'id_imun'   => (int)$request->id_imun,
            'tgl_imun'  => $request->tgl_imun,
            'ket'       => $request->ket,
        ]);

        return redirect('/posyandu/bumil-imun')->with('success','Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        BumilImunisasi::where('id_bumil_imun',$id)->delete();
        return redirect('/posyandu/bumil-imun')->with('success','Data berhasil dihapus');
    }
}