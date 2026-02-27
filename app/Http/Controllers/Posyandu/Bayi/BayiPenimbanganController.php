<?php

namespace App\Http\Controllers\Posyandu\Bayi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\BayiPnb;

class BayiPenimbanganController extends Controller
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

        $query = DB::table('bayi_pnb as p')
            ->leftJoin('bayi as b','b.id_bayi','=','p.id_bayi')
            ->leftJoin('wuspus as w','w.id_wuspus','=','b.id_wuspus')
            ->leftJoin('duspy as d','d.id_posyandu','=','w.id_posyandu')
            ->leftJoin('klrhn as kel','kel.id_kel','=','d.id_kel')
            ->leftJoin('kcmtn as kec','kec.id_kec','=','kel.id_kec')
            ->select([
                'p.id_bayi_pnb',
                'p.tgl_pnb',
                'p.berat',
                'p.tb',
                'p.hasil',
                'p.pmt',
                'p.ket',
                'b.nama_bayi',
                'd.nama_posyandu',
                'kel.nama_kel',
                'kec.nama_kec',
            ])
            ->orderByDesc('p.id_bayi_pnb');

        if ($kec !== '') $query->where('kec.id_kec',$kec);
        if ($kel !== '') $query->where('kel.id_kel',$kel);
        if ($pos !== '') $query->where('d.id_posyandu',$pos);
        if ($q !== '') {
            $query->where('b.nama_bayi','like',"%{$q}%");
        }

        $data = $query->paginate(20)->withQueryString();

        return Inertia::render('bayi/penimbangan/Index', [
            'data'=>$data,
            'kecamatan'=>$kecamatan,
            'kelurahan'=>$kelurahan,
            'posyandu'=>$posyandu,
            'filter'=>compact('kec','kel','pos','q'),
        ]);
    }

    public function create()
    {
        $kecamatan = DB::table('kcmtn')->select('id_kec','nama_kec')->get();
        $kelurahan = DB::table('klrhn')->select('id_kel','id_kec','nama_kel')->get()->groupBy('id_kec');
        $posyandu  = DB::table('duspy')->select('id_posyandu','id_kel','nama_posyandu')->get()->groupBy('id_kel');

        $bayi = DB::table('bayi as b')
            ->leftJoin('wuspus as w','w.id_wuspus','=','b.id_wuspus')
            ->select('b.id_bayi','b.nama_bayi','w.id_posyandu')
            ->get()
            ->groupBy('id_posyandu');

        return Inertia::render('bayi/penimbangan/Create', compact(
            'kecamatan','kelurahan','posyandu','bayi'
        ));
    }

    public function storeMultiple(Request $request)
    {
        $request->validate([
            'posyandu_id'=>'required',
            'rows'=>'required|array|min:1',
            'rows.*.id_bayi'=>'required|exists:bayi,id_bayi',
            'rows.*.tgl_pnb'=>'required|date',
            'rows.*.berat'=>'nullable|numeric',
            'rows.*.tb'=>'nullable|numeric',
        ]);

        DB::transaction(function() use ($request){
            foreach($request->rows as $r){
                BayiPnb::create([
                    'id_bayi'=>$r['id_bayi'],
                    'tgl_pnb'=>$r['tgl_pnb'],
                    'berat'=>isset($r['berat']) && $r['berat'] !== '' ? (float)$r['berat'] : null,
                    'tb'=>isset($r['tb']) && $r['tb'] !== '' ? (float)$r['tb'] : null,
                    'hasil'=>$r['hasil'] ?? null,
                    'pmt'=>$r['pmt'] ?? null,
                    'ket'=>$r['ket'] ?? null,
                ]);
            }
        });

        return redirect('/posyandu/bayi-pnb')->with('success','Data penimbangan bayi tersimpan');
    }

    public function show($id)
    {
        
        $row = DB::table('bayi_pnb as p')
            ->leftJoin('bayi as b','b.id_bayi','=','p.id_bayi')
            ->leftJoin('wuspus as w','w.id_wuspus','=','b.id_wuspus')
            ->leftJoin('duspy as d','d.id_posyandu','=','w.id_posyandu')
            ->leftJoin('klrhn as kel','kel.id_kel','=','d.id_kel')
            ->leftJoin('kcmtn as kec','kec.id_kec','=','kel.id_kec')
            ->where('p.id_bayi_pnb',$id)
            ->select('p.*','b.nama_bayi','d.nama_posyandu','kel.nama_kel','kec.nama_kec')
            ->first();

        abort_if(!$row,404);

        return Inertia::render('bayi/penimbangan/Show',['row'=>$row]);
    }

   public function edit($id)
{
    $row = DB::table('bayi_pnb as p')
        ->leftJoin('bayi as b','b.id_bayi','=','p.id_bayi')
        ->leftJoin('wuspus as w','w.id_wuspus','=','b.id_wuspus')
        ->leftJoin('duspy as d','d.id_posyandu','=','w.id_posyandu')
        ->leftJoin('klrhn as kel','kel.id_kel','=','d.id_kel')
        ->leftJoin('kcmtn as kec','kec.id_kec','=','kel.id_kec')
        ->select([
            'p.id_bayi_pnb',
            'p.id_bayi as p_id_bayi',
            'p.tgl_pnb',
            'p.berat',
            'p.tb',
            'p.hasil',
            'p.ket',

            'b.nama_bayi',

            'd.id_posyandu',
            'd.nama_posyandu',

            'kel.id_kel',
            'kel.nama_kel',

            'kec.id_kec',
            'kec.nama_kec',
        ])
        ->where('p.id_bayi_pnb', $id)
        ->first();

    abort_if(!$row,404);

    $kecamatan = DB::table('kcmtn')
        ->select('id_kec','nama_kec')
        ->orderBy('nama_kec')
        ->get();

    $kelurahan = DB::table('klrhn')
        ->select('id_kel','id_kec','nama_kel')
        ->orderBy('nama_kel')
        ->get()
        ->groupBy('id_kec');

    $posyandu  = DB::table('duspy')
        ->select('id_posyandu','id_kel','nama_posyandu')
        ->orderBy('nama_posyandu')
        ->get()
        ->groupBy('id_kel');

    return Inertia::render('bayi/penimbangan/Edit', compact(
        'row','kecamatan','kelurahan','posyandu'
    ));
}

    public function update(Request $request,$id)
    {
        BayiPnb::where('id_bayi_pnb',$id)->update($request->only([
            'tgl_pnb','berat','tb','hasil','pmt','ket'
        ]));

        return redirect('/posyandu/bayi-pnb')->with('success','Data diperbarui');
    }

    public function destroy($id)
    {
        BayiPnb::where('id_bayi_pnb',$id)->delete();
        return back()->with('success','Data dihapus');
    }
}