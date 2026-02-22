<?php

namespace App\Http\Controllers\Posyandu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\BumilPenimbangan;

class BumilPenimbanganController extends Controller
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

        $query = DB::table('bumil_pnb as p')
            ->leftJoin('wuspus as w','w.id_wuspus','=','p.id_wuspus')
            ->leftJoin('duspy as d','d.id_posyandu','=','w.id_posyandu')
            ->leftJoin('klrhn as kel','kel.id_kel','=','d.id_kel')
            ->leftJoin('kcmtn as kec','kec.id_kec','=','kel.id_kec')
            ->select([
                'p.id_bumil_pnb',
                'p.id_wuspus',
                'p.bln_hamil',
                'p.tgl_pnb',
                'p.berat',
                'p.hasil',
                'p.ket',

                'w.nik_wuspus',
                'w.nama_wuspus',

                'd.id_posyandu',
                'd.nama_posyandu',

                'kel.id_kel',
                'kel.nama_kel',

                'kec.id_kec',
                'kec.nama_kec',
            ])
            ->orderByDesc('p.tgl_pnb')
            ->orderByDesc('p.id_bumil_pnb');

        if ($kec !== '') $query->where('kec.id_kec', $kec);
        if ($kel !== '') $query->where('kel.id_kel', $kel);
        if ($pos !== '') $query->where('d.id_posyandu', $pos);

        if ($q !== '') {
            $query->where(function($x) use ($q){
                $x->where('w.nama_wuspus','like',"%{$q}%")
                  ->orWhere('w.nik_wuspus','like',"%{$q}%")
                  ->orWhere('d.nama_posyandu','like',"%{$q}%")
                  ->orWhere('p.hasil','like',"%{$q}%");
            });
        }

        $data = $query->paginate(20)->withQueryString();

        return Inertia::render('bumil/penimbangan/Index', [
            'data' => $data,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'posyandu'  => $posyandu,
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

        // WUS/PUS dikelompokkan per posyandu (ikut panutan biodata)
        $wuspus = DB::table('wuspus')
            ->select('id_wuspus', 'id_posyandu', 'nik_wuspus', 'nama_wuspus')
            ->orderBy('nama_wuspus')
            ->get()
            ->groupBy('id_posyandu');

        return Inertia::render('bumil/penimbangan/Create', [
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
            'rows' => ['required','array','min:1'],

            'rows.*.id_wuspus' => ['required','integer','exists:wuspus,id_wuspus'],
            'rows.*.bln_hamil' => ['nullable','string','max:50'],
            'rows.*.tgl_pnb'   => ['required','date'],
            'rows.*.berat'     => ['nullable','numeric'],
            'rows.*.hasil'     => ['nullable','string','max:100'],
            'rows.*.ket'       => ['nullable','string'],
        ]);

        $rows = $request->input('rows', []);

        DB::beginTransaction();
        try{
            foreach($rows as $r){
                DB::table('bumil_pnb')->insert([
                    'id_wuspus' => (int)($r['id_wuspus']),
                    'bln_hamil' => $r['bln_hamil'] ?? null,
                    'tgl_pnb'   => $r['tgl_pnb'],
                    'berat'     => ($r['berat'] !== '' && $r['berat'] !== null) ? (float)$r['berat'] : null,
                    'hasil'     => $r['hasil'] ?? null,
                    'ket'       => $r['ket'] ?? null,
                ]);
            }
            DB::commit();
        }catch(\Throwable $e){
            DB::rollBack();
            throw $e;
        }

        return redirect('/posyandu/bumil-pnb')->with('success','Data penimbangan bumil berhasil disimpan');
    }

    public function show($id)
    {
        $row = DB::table('bumil_pnb as p')
            ->leftJoin('wuspus as w','w.id_wuspus','=','p.id_wuspus')
            ->leftJoin('duspy as d','d.id_posyandu','=','w.id_posyandu')
            ->leftJoin('klrhn as kel','kel.id_kel','=','d.id_kel')
            ->leftJoin('kcmtn as kec','kec.id_kec','=','kel.id_kec')
            ->where('p.id_bumil_pnb',$id)
            ->select([
                'p.*',
                'w.nik_wuspus',
                'w.nama_wuspus',
                'd.nama_posyandu',
                'kel.nama_kel',
                'kec.nama_kec',
            ])
            ->first();

        abort_if(!$row,404);

        return Inertia::render('bumil/penimbangan/Show', ['row'=>$row]);
    }

    public function edit($id)
    {
        $row = DB::table('bumil_pnb as p')
            ->leftJoin('wuspus as w','w.id_wuspus','=','p.id_wuspus')
            ->leftJoin('duspy as d','d.id_posyandu','=','w.id_posyandu')
            ->leftJoin('klrhn as kel','kel.id_kel','=','d.id_kel')
            ->leftJoin('kcmtn as kec','kec.id_kec','=','kel.id_kec')
            ->select([
                'p.*',
                'w.id_posyandu',
                'w.nik_wuspus',
                'w.nama_wuspus',
                'd.id_kel',
                'kel.id_kec',
                'kec.nama_kec',
                'kel.nama_kel',
                'd.nama_posyandu',
            ])
            ->where('p.id_bumil_pnb', $id)
            ->first();

        abort_if(!$row, 404);

        $kecamatan = DB::table('kcmtn')->select('id_kec', 'nama_kec')->orderBy('nama_kec')->get();
        $kelurahan = DB::table('klrhn')->select('id_kel', 'id_kec', 'nama_kel')->orderBy('nama_kel')->get()->groupBy('id_kec');
        $posyandu  = DB::table('duspy')->select('id_posyandu', 'id_kel', 'nama_posyandu')->orderBy('nama_posyandu')->get()->groupBy('id_kel');
        $wuspus    = DB::table('wuspus')->select('id_wuspus', 'id_posyandu', 'nik_wuspus', 'nama_wuspus')->orderBy('nama_wuspus')->get()->groupBy('id_posyandu');

        return Inertia::render('bumil/penimbangan/Edit', [
            'row' => $row,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'posyandu'  => $posyandu,
            'wuspus'    => $wuspus,
        ]);
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'id_wuspus' => ['required','integer','exists:wuspus,id_wuspus'],
            'bln_hamil' => ['nullable','string','max:50'],
            'tgl_pnb'   => ['required','date'],
            'berat'     => ['nullable','numeric'],
            'hasil'     => ['nullable','string','max:100'],
            'ket'       => ['nullable','string'],
        ]);

        BumilPenimbangan::where('id_bumil_pnb',$id)->update([
            'id_wuspus' => (int)$request->id_wuspus,
            'bln_hamil' => $request->bln_hamil,
            'tgl_pnb'   => $request->tgl_pnb,
            'berat'     => ($request->berat !== '' && $request->berat !== null) ? (float)$request->berat : null,
            'hasil'     => $request->hasil,
            'ket'       => $request->ket,
        ]);

        return redirect('/posyandu/bumil-pnb')->with('success','Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        BumilPenimbangan::where('id_bumil_pnb',$id)->delete();
        return redirect('/posyandu/bumil-pnb')->with('success','Data berhasil dihapus');
    }
}