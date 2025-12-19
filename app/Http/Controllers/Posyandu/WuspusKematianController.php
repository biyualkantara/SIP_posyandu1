<?php

namespace App\Http\Controllers\Posyandu;

use App\Http\Controllers\Controller;
use App\Models\Wuspus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class WuspusKematianController extends Controller
{
    public function index(Request $request)
    {
        $kec = $request->get('kec','');
        $kel = $request->get('kel','');
        $pos = $request->get('pos','');
        $q   = $request->get('q','');

        $kecamatan = DB::table('kcmtn')->select('id_kec','nama_kec')->orderBy('nama_kec')->get();
        $kelurahan = DB::table('klrhn')->select('id_kel','id_kec','nama_kel')->orderBy('nama_kel')->get()->groupBy('id_kec');
        $posyandu  = DB::table('duspy')->select('id_posyandu','id_kel','nama_posyandu')->orderBy('nama_posyandu')->get()->groupBy('id_kel');

        $query = DB::table('wuspus as w')
            ->leftJoin('duspy as d','d.id_posyandu','=','w.id_posyandu')
            ->leftJoin('klrhn as kel','kel.id_kel','=','d.id_kel')
            ->leftJoin('kcmtn as kec','kec.id_kec','=','kel.id_kec')
            ->select([
                'w.id_wuspus',
                'w.nik_wuspus',
                'w.nama_wuspus',
                'w.status',
                'w.ket',
                'd.id_posyandu',
                'd.nama_posyandu',
                'kel.id_kel','kel.nama_kel',
                'kec.id_kec','kec.nama_kec',
            ])
            ->where('w.status', 'Meninggal')
            ->orderByDesc('w.id_wuspus');

        if($kec !== '') $query->where('kec.id_kec',$kec);
        if($kel !== '') $query->where('kel.id_kel',$kel);
        if($pos !== '') $query->where('d.id_posyandu',$pos);

        if($q !== ''){
            $query->where(function($x) use ($q){
                $x->where('w.nama_wuspus','like',"%{$q}%")
                  ->orWhere('w.nik_wuspus','like',"%{$q}%")
                  ->orWhere('d.nama_posyandu','like',"%{$q}%")
                  ->orWhere('w.ket','like',"%{$q}%");
            });
        }

        return Inertia::render('wuspus/kematian/Index', [
            'data' => $query->paginate(20)->withQueryString(),
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'posyandu' => $posyandu,
            'filter' => ['kec'=>$kec,'kel'=>$kel,'pos'=>$pos,'q'=>$q],
        ]);
    }

    public function create()
    {
        $kecamatan = DB::table('kcmtn')->select('id_kec','nama_kec')->orderBy('nama_kec')->get();
        $kelurahan = DB::table('klrhn')->select('id_kel','id_kec','nama_kel')->orderBy('nama_kel')->get()->groupBy('id_kec');
        $posyandu  = DB::table('duspy')->select('id_posyandu','id_kel','nama_posyandu')->orderBy('nama_posyandu')->get()->groupBy('id_kel');

        $wuspus = DB::table('wuspus')
            ->select('id_wuspus','id_posyandu','nik_wuspus','nama_wuspus','status')
            ->orderBy('nama_wuspus')
            ->get()
            ->groupBy('id_posyandu');

        return Inertia::render('wuspus/kematian/Create', [
            'kecamatan'=>$kecamatan,
            'kelurahan'=>$kelurahan,
            'posyandu'=>$posyandu,
            'wuspus'=>$wuspus,
        ]);
    }

    public function storeMultiple(Request $request)
    {
        $request->validate([
            'kecamatan_id' => ['nullable'],
            'kelurahan_id' => ['required'],
            'posyandu_id'  => ['required'],
            'rows' => ['required','array','min:1'],
            'rows.*.id_wuspus' => ['required','exists:wuspus,id_wuspus'],
            'rows.*.ket' => ['nullable','string'],
        ]);

        DB::beginTransaction();
        try{
            foreach($request->rows as $r){
                Wuspus::where('id_wuspus',(int)$r['id_wuspus'])->update([
                    'status' => 'Meninggal',
                    'ket' => $r['ket'] ?? null,
                ]);
            }
            DB::commit();
        }catch(\Throwable $e){
            DB::rollBack();
            throw $e;
        }

        return redirect('/posyandu/wuspus-kematian')->with('success','Data kematian WUS/PUS berhasil disimpan');
    }

    public function show($id)
    {
        $row = DB::table('wuspus as w')
            ->leftJoin('duspy as d','d.id_posyandu','=','w.id_posyandu')
            ->leftJoin('klrhn as kel','kel.id_kel','=','d.id_kel')
            ->leftJoin('kcmtn as kec','kec.id_kec','=','kel.id_kec')
            ->select([
                'w.*',
                'd.nama_posyandu',
                'kel.nama_kel',
                'kec.nama_kec',
            ])
            ->where('w.id_wuspus',$id)
            ->where('w.status','Meninggal')
            ->first();

        abort_if(!$row,404);

        return Inertia::render('wuspus/kematian/Show', ['row'=>$row]);
    }

    public function edit($id)
    {
        $row = Wuspus::where('id_wuspus',$id)->firstOrFail();

        $kecamatan = DB::table('kcmtn')->select('id_kec','nama_kec')->orderBy('nama_kec')->get();
        $kelurahan = DB::table('klrhn')->select('id_kel','id_kec','nama_kel')->orderBy('nama_kel')->get()->groupBy('id_kec');
        $posyandu  = DB::table('duspy')->select('id_posyandu','id_kel','nama_posyandu')->orderBy('nama_posyandu')->get()->groupBy('id_kel');
        $wuspus    = DB::table('wuspus')->select('id_wuspus','id_posyandu','nik_wuspus','nama_wuspus','status')->orderBy('nama_wuspus')->get()->groupBy('id_posyandu');

        return Inertia::render('wuspus/kematian/Edit', [
            'row'=>$row,
            'kecamatan'=>$kecamatan,
            'kelurahan'=>$kelurahan,
            'posyandu'=>$posyandu,
            'wuspus'=>$wuspus,
        ]);
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'status' => ['required','string','max:100'],
            'ket' => ['nullable'],
        ]);

        Wuspus::where('id_wuspus',$id)->update([
            'status' => $request->status,
            'ket' => $request->ket,
        ]);

        return redirect('/posyandu/wuspus-kematian')->with('success','Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        // delete di menu kematian = reset status menjadi NULL (atau “Aktif”), bukan hapus record
        Wuspus::where('id_wuspus',$id)->update([
            'status' => null,
            'ket' => null,
        ]);

        return back()->with('success','Status kematian dibatalkan');
    }
}