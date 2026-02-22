<?php

namespace App\Http\Controllers\Posyandu\Bayi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\Bayi;

class BayiBiodataController extends Controller
{
    public function index(Request $request)
    {
        $kec = $request->get('kec', '');
        $kel = $request->get('kel', '');
        $pos = $request->get('pos', '');
        $q   = $request->get('q', '');

        $kecamatan = DB::table('kcmtn')->select('id_kec','nama_kec')->orderBy('nama_kec')->get();
        $kelurahan = DB::table('klrhn')->select('id_kel','id_kec','nama_kel')->orderBy('nama_kel')->get()->groupBy('id_kec');
        $posyandu  = DB::table('duspy')->select('id_posyandu','id_kel','nama_posyandu')->orderBy('nama_posyandu')->get()->groupBy('id_kel');

        $query = DB::table('bayi as b')
            ->leftJoin('wuspus as w','w.id_wuspus','=','b.id_wuspus')
            ->leftJoin('duspy as d','d.id_posyandu','=','w.id_posyandu')
            ->leftJoin('klrhn as kel','kel.id_kel','=','d.id_kel')
            ->leftJoin('kcmtn as kec','kec.id_kec','=','kel.id_kec')
            ->select([
                'b.id_bayi',
                'b.id_wuspus',
                'b.tgl_daftar',
                'b.nama_bayi',
                'b.jk',
                'b.tgl_lhr',
                'b.bb',
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
            ->orderByDesc('b.id_bayi');

        if ($kec !== '') $query->where('kec.id_kec',$kec);
        if ($kel !== '') $query->where('kel.id_kel',$kel);
        if ($pos !== '') $query->where('d.id_posyandu',$pos);

        if ($q !== '') {
            $query->where(function($x) use ($q){
                $x->where('b.nama_bayi','like',"%{$q}%")
                  ->orWhere('w.nama_wuspus','like',"%{$q}%")
                  ->orWhere('w.nik_wuspus','like',"%{$q}%");
            });
        }

        $data = $query->paginate(20)->withQueryString();

        return Inertia::render('bayi/biodata/Index',[
            'data'=>$data,
            'kecamatan'=>$kecamatan,
            'kelurahan'=>$kelurahan,
            'posyandu'=>$posyandu,
            'filter'=>[
                'kec'=>$kec,
                'kel'=>$kel,
                'pos'=>$pos,
                'q'=>$q,
            ]
        ]);
    }

    public function create()
    {
        $kecamatan = DB::table('kcmtn')->select('id_kec','nama_kec')->orderBy('nama_kec')->get();
        $kelurahan = DB::table('klrhn')->select('id_kel','id_kec','nama_kel')->orderBy('nama_kel')->get()->groupBy('id_kec');
        $posyandu  = DB::table('duspy')->select('id_posyandu','id_kel','nama_posyandu')->orderBy('nama_posyandu')->get()->groupBy('id_kel');

        $wuspus = DB::table('wuspus')
            ->select('id_wuspus','id_posyandu','nik_wuspus','nama_wuspus')
            ->orderBy('nama_wuspus')
            ->get()
            ->groupBy('id_posyandu');

        return Inertia::render('bayi/biodata/Create',[
            'kecamatan'=>$kecamatan,
            'kelurahan'=>$kelurahan,
            'posyandu'=>$posyandu,
            'wuspus'=>$wuspus,
        ]);
    }

    public function storeMultiple(Request $request)
    {
        $request->validate([
            'kelurahan_id'=>['required'],
            'posyandu_id'=>['required'],
            'rows'=>['required','array','min:1'],
            'rows.*.id_wuspus'=>['required','integer','exists:wuspus,id_wuspus'],
            'rows.*.nama_bayi'=>['required','string'],
            'rows.*.jk'=>['required'],
            'rows.*.tgl_lhr'=>['required','date'],
            'rows.*.bb'=>['nullable','numeric'],
            'rows.*.ket'=>['nullable','string'],
        ]);

        DB::beginTransaction();
        try{
            foreach($request->rows as $r){
                DB::table('bayi')->insert([
                    'id_wuspus'=>$r['id_wuspus'],
                    'tgl_daftar'=>now(),
                    'nama_bayi'=>$r['nama_bayi'],
                    'jk'=>$r['jk'],
                    'tgl_lhr'=>$r['tgl_lhr'],
                    'bb'=>$r['bb'] ?? null,
                    'ket'=>$r['ket'] ?? null,
                ]);
            }
            DB::commit();
        }catch(\Throwable $e){
            DB::rollBack();
            throw $e;
        }

        return redirect('/posyandu/bayi')->with('success','Data bayi berhasil disimpan');
    }

    public function show($id)
    {
        $row = DB::table('bayi as b')
            ->leftJoin('wuspus as w','w.id_wuspus','=','b.id_wuspus')
            ->leftJoin('duspy as d','d.id_posyandu','=','w.id_posyandu')
            ->leftJoin('klrhn as kel','kel.id_kel','=','d.id_kel')
            ->leftJoin('kcmtn as kec','kec.id_kec','=','kel.id_kec')
            ->where('b.id_bayi',$id)
            ->select([
                'b.*',
                'w.nik_wuspus',
                'w.nama_wuspus',
                'd.nama_posyandu',
                'kel.nama_kel',
                'kec.nama_kec',
            ])
            ->first();

        abort_if(!$row,404);

        return Inertia::render('bayi/biodata/Show',['row'=>$row]);
    }

    public function edit($id)
    {
        $row = DB::table('bayi')->where('id_bayi',$id)->first();
        abort_if(!$row,404);

        $kecamatan = DB::table('kcmtn')->select('id_kec','nama_kec')->orderBy('nama_kec')->get();
        $kelurahan = DB::table('klrhn')->select('id_kel','id_kec','nama_kel')->orderBy('nama_kel')->get()->groupBy('id_kec');
        $posyandu  = DB::table('duspy')->select('id_posyandu','id_kel','nama_posyandu')->orderBy('nama_posyandu')->get()->groupBy('id_kel');
        $wuspus    = DB::table('wuspus')->select('id_wuspus','id_posyandu','nik_wuspus','nama_wuspus')->orderBy('nama_wuspus')->get()->groupBy('id_posyandu');

        return Inertia::render('bayi/biodata/Edit',[
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
            'id_wuspus'=>['required','integer'],
            'nama_bayi'=>['required'],
            'jk'=>['required'],
            'tgl_lhr'=>['required','date'],
            'bb'=>['nullable','numeric'],
            'ket'=>['nullable'],
        ]);

        Bayi::where('id_bayi',$id)->update($request->only([
            'id_wuspus','nama_bayi','jk','tgl_lhr','bb','ket'
        ]));

        return redirect('/posyandu/bayi')->with('success','Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        Bayi::where('id_bayi',$id)->delete();
        return redirect('/posyandu/bayi')->with('success','Data berhasil dihapus');
    }
}