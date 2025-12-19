<?php

namespace App\Http\Controllers\Posyandu;

use App\Http\Controllers\Controller;
use App\Models\WuspusKontrasepsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class WuspusKontrasepsiController extends Controller
{
    public function index(Request $request)
    {
        $kec = $request->get('kec', '');
        $kel = $request->get('kel', '');
        $pos = $request->get('pos', '');
        $q   = $request->get('q', '');

        $kecamatan = DB::table('kcmtn')
            ->select('id_kec','nama_kec')
            ->orderBy('nama_kec')
            ->get();

        $kelurahan = DB::table('klrhn')
            ->select('id_kel','id_kec','nama_kel')
            ->orderBy('nama_kel')
            ->get()
            ->groupBy('id_kec');

        $posyandu = DB::table('duspy')
            ->select('id_posyandu','id_kel','nama_posyandu')
            ->orderBy('nama_posyandu')
            ->get()
            ->groupBy('id_kel');

        $query = DB::table('wuspus_kontrasepsi as kb')
            ->leftJoin('wuspus as w','w.id_wuspus','=','kb.id_wuspus')
            ->leftJoin('duspy as d','d.id_posyandu','=','w.id_posyandu')
            ->leftJoin('klrhn as kelx','kelx.id_kel','=','d.id_kel')
            ->leftJoin('kcmtn as kecx','kecx.id_kec','=','kelx.id_kec')
            ->select([
                'kb.id_wkp',
                'kb.id_wuspus',
                'kb.jns_kontrasepsi',
                'kb.tgl_ganti',
                'kb.kontrasepsi_baru',
                'kb.ket',
                'w.nik_wuspus',
                'w.nama_wuspus',
                'd.id_posyandu',
                'd.nama_posyandu',
                'kelx.id_kel',
                'kelx.nama_kel',
                'kecx.id_kec',
                'kecx.nama_kec',
            ])
            ->orderByDesc('kb.tgl_ganti')
            ->orderByDesc('kb.id_wkp');

        if ($kec !== '') $query->where('kecx.id_kec', $kec);
        if ($kel !== '') $query->where('kelx.id_kel', $kel);
        if ($pos !== '') $query->where('d.id_posyandu', $pos);

        if ($q !== '') {
            $query->where(function($x) use ($q){
                $x->where('w.nama_wuspus','like',"%{$q}%")
                  ->orWhere('w.nik_wuspus','like',"%{$q}%")
                  ->orWhere('kb.jns_kontrasepsi','like',"%{$q}%")
                  ->orWhere('kb.kontrasepsi_baru','like',"%{$q}%")
                  ->orWhere('d.nama_posyandu','like',"%{$q}%");
            });
        }

        return Inertia::render('wuspus/kontrasepsi/Index',[
            'data' => $query->paginate(20)->withQueryString(),
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'posyandu'  => $posyandu,
            'filter'    => compact('kec','kel','pos','q'),
        ]);
    }

    public function create()
    {
        $kecamatan = DB::table('kcmtn')->select('id_kec','nama_kec')->orderBy('nama_kec')->get();

        $kelurahan = DB::table('klrhn')
            ->select('id_kel','id_kec','nama_kel')
            ->orderBy('nama_kel')
            ->get()
            ->groupBy('id_kec');

        $posyandu = DB::table('duspy')
            ->select('id_posyandu','id_kel','nama_posyandu')
            ->orderBy('nama_posyandu')
            ->get()
            ->groupBy('id_kel');

        $wuspus = DB::table('wuspus')
            ->select('id_wuspus','id_posyandu','nik_wuspus','nama_wuspus')
            ->orderBy('nama_wuspus')
            ->get()
            ->groupBy('id_posyandu');

        return Inertia::render('wuspus/kontrasepsi/Create',[
            'kecamatan'=>$kecamatan,
            'kelurahan'=>$kelurahan,
            'posyandu'=>$posyandu,
            'wuspus'=>$wuspus,
        ]);
    }

    public function storeMultiple(Request $request)
    {
        $request->validate([
            'kelurahan_id' => ['required'],
            'posyandu_id'  => ['required','exists:duspy,id_posyandu'],
            'rows' => ['required','array','min:1'],
            'rows.*.id_wuspus' => ['required','exists:wuspus,id_wuspus'],
            'rows.*.jns_kontrasepsi' => ['required','string','max:120'],
            'rows.*.tgl_ganti' => ['required','date'],
            'rows.*.kontrasepsi_baru' => ['nullable','string','max:120'],
            'rows.*.ket' => ['nullable','string'],
        ]);

        DB::transaction(function() use ($request){
            foreach($request->rows as $r){
                DB::table('wuspus_kontrasepsi')->insert([
                    'id_wuspus' => (int)$r['id_wuspus'],
                    'jns_kontrasepsi' => $r['jns_kontrasepsi'],
                    'tgl_ganti' => $r['tgl_ganti'],
                    'kontrasepsi_baru' => $r['kontrasepsi_baru'] ?? null,
                    'ket' => $r['ket'] ?? null,
                ]);
            }
        });

        return redirect('/posyandu/wuspus-kontrasepsi')
            ->with('success','Data kontrasepsi WUS/PUS berhasil disimpan');
    }

    public function show($id)
    {
        $row = DB::table('wuspus_kontrasepsi as kb')
            ->leftJoin('wuspus as w','w.id_wuspus','=','kb.id_wuspus')
            ->leftJoin('duspy as d','d.id_posyandu','=','w.id_posyandu')
            ->leftJoin('klrhn as kelx','kelx.id_kel','=','d.id_kel')
            ->leftJoin('kcmtn as kecx','kecx.id_kec','=','kelx.id_kec')
            ->where('kb.id_wkp',$id)
            ->select([
                'kb.*',
                'w.nik_wuspus',
                'w.nama_wuspus',
                'd.nama_posyandu',
                'kelx.nama_kel',
                'kecx.nama_kec',
            ])
            ->first();

        abort_if(!$row,404);

        return Inertia::render('wuspus/kontrasepsi/Show',['row'=>$row]);
    }

    public function edit($id)
    {
        $row = WuspusKontrasepsi::where('id_wkp',$id)->firstOrFail();

        $wuspus = DB::table('wuspus')
            ->select('id_wuspus','nik_wuspus','nama_wuspus')
            ->orderBy('nama_wuspus')
            ->get();

        return Inertia::render('wuspus/kontrasepsi/Edit',[
            'row'=>$row,
            'wuspus'=>$wuspus,
        ]);
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'id_wuspus' => ['required','exists:wuspus,id_wuspus'],
            'jns_kontrasepsi' => ['required','string','max:120'],
            'tgl_ganti' => ['required','date'],
            'kontrasepsi_baru' => ['nullable','string','max:120'],
            'ket' => ['nullable','string'],
        ]);

        WuspusKontrasepsi::where('id_wkp',$id)->update([
            'id_wuspus' => (int)$request->id_wuspus,
            'jns_kontrasepsi' => $request->jns_kontrasepsi,
            'tgl_ganti' => $request->tgl_ganti,
            'kontrasepsi_baru' => $request->kontrasepsi_baru,
            'ket' => $request->ket,
        ]);

        return redirect('/posyandu/wuspus-kontrasepsi')
            ->with('success','Data kontrasepsi berhasil diperbarui');
    }

    public function destroy($id)
    {
        WuspusKontrasepsi::where('id_wkp',$id)->delete();

        return redirect('/posyandu/wuspus-kontrasepsi')
            ->with('success','Data kontrasepsi berhasil dihapus');
    }
}