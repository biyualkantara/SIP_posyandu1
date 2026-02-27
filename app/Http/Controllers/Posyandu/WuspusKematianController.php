<?php

namespace App\Http\Controllers\Posyandu;

use App\Http\Controllers\Controller;
use App\Models\Wuspus;
use App\Models\WuspusKematian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class WuspusKematianController extends Controller
{
    // INDEX
    public function index(Request $request)
    {
        $kec = $request->get('kec','');
        $kel = $request->get('kel','');
        $pos = $request->get('pos','');
        $q   = $request->get('q','');

        $kecamatan = DB::table('kcmtn')->select('id_kec','nama_kec')->orderBy('nama_kec')->get();
        $kelurahan = DB::table('klrhn')->select('id_kel','id_kec','nama_kel')->orderBy('nama_kel')->get()->groupBy('id_kec');
        $posyandu  = DB::table('duspy')->select('id_posyandu','id_kel','nama_posyandu')->orderBy('nama_posyandu')->get()->groupBy('id_kel');

        $query = DB::table('wuspus_kematians as wk')
            ->join('wuspus as w','w.id_wuspus','=','wk.id_wuspus')
            ->leftJoin('duspy as d','d.id_posyandu','=','w.id_posyandu')
            ->leftJoin('klrhn as kel','kel.id_kel','=','d.id_kel')
            ->leftJoin('kcmtn as kec','kec.id_kec','=','kel.id_kec')
            ->select([
                'wk.*',
                'w.nik_wuspus',
                'w.nama_wuspus',
                'w.status',
                'd.nama_posyandu',
                'kel.nama_kel',
                'kec.nama_kec'
            ])
            ->orderByDesc('wk.id');

        if($kec) $query->where('kec.id_kec',$kec);
        if($kel) $query->where('kel.id_kel',$kel);
        if($pos) $query->where('d.id_posyandu',$pos);

        if($q){
            $query->where(function($x) use ($q){
                $x->where('w.nama_wuspus','like',"%{$q}%")
                  ->orWhere('w.nik_wuspus','like',"%{$q}%")
                  ->orWhere('d.nama_posyandu','like',"%{$q}%")
                  ->orWhere('wk.ket','like',"%{$q}%");
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

    // CREATE
        public function create()
        {
            $wuspus = Wuspus::where('status','Aktif')
                ->select('id_wuspus','nik_wuspus','nama_wuspus')
                ->orderBy('nama_wuspus')
                ->get();

            return Inertia::render('wuspus/kematian/Create', [
                'wuspus' => $wuspus
            ]);
        }


        // STORE
        public function store(Request $request)
        {
            $request->validate([
                'id_wuspus'  => ['required','exists:wuspus,id_wuspus'],
                'tgl_wafat'  => ['required','date'],
                'penyebab'   => ['nullable','string'],
                'ket'        => ['nullable','string'],
            ]);

            DB::transaction(function () use ($request) {

                // simpan data kematian
                WuspusKematian::create([
                    'id_wuspus' => $request->id_wuspus,
                    'tgl_wafat' => $request->tgl_wafat,
                    'penyebab'  => $request->penyebab,
                    'ket'       => $request->ket,
                ]);

                // ubah status WUS/PUS
                Wuspus::where('id_wuspus',$request->id_wuspus)
                    ->update(['status' => 'Meninggal']);
            });

            return redirect('/posyandu/wuspus-kematian')
                ->with('success','Data kematian berhasil disimpan');
        }

         // SHOW - PERBAIKAN
    public function show($id)
    {
    
        $row = WuspusKematian::from('wuspus_kematians as wk')
            ->join('wuspus as w', 'w.id_wuspus', '=', 'wk.id_wuspus')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->select([
                'wk.*',
                'w.nik_wuspus',
                'w.nama_wuspus',
                'w.status',
                'd.nama_posyandu',
                'kel.nama_kel',
                'kec.nama_kec'
            ])
            ->where('wk.id', $id) // PERBAIKAN: where id (primary key tabel kematian)
            ->firstOrFail();

        return Inertia::render('wuspus/kematian/Show', ['row' => $row]);
    }

    // EDIT - PERBAIKAN
    public function edit($id)
    {
        // Cari berdasarkan id tabel wuspus_kematians
        $row = WuspusKematian::from('wuspus_kematians as wk')
            ->join('wuspus as w','w.id_wuspus','=','wk.id_wuspus')
            ->leftJoin('duspy as d','d.id_posyandu','=','w.id_posyandu')
            ->leftJoin('klrhn as kel','kel.id_kel','=','d.id_kel')
            ->leftJoin('kcmtn as kec','kec.id_kec','=','kel.id_kec')
            ->select([
                'wk.*',
                'w.nik_wuspus',
                'w.nama_wuspus',
                'w.status',
                'd.nama_posyandu',
                'kel.nama_kel',
                'kec.nama_kec'
            ])
            ->where('wk.id', $id) // PERBAIKAN: where id (primary key tabel kematian)
            ->firstOrFail();

        return Inertia::render('wuspus/kematian/Edit', ['row' => $row]);
    }

     // UPDATE - PERBAIKAN
    public function update(Request $request, $id)
    {
        $request->validate([
            'ket' => ['nullable','string'],
            'restore' => ['nullable','boolean'],
        ]);

        // Cari data kematian berdasarkan id
        $kematian = WuspusKematian::findOrFail($id);
        $id_wuspus = $kematian->id_wuspus;

        // Update WUS/PUS status
        $status = $request->restore ? 'Aktif' : 'Meninggal';
        Wuspus::where('id_wuspus', $id_wuspus)->update(['status' => $status]);

        // Update keterangan di WuspusKematian
        $kematian->update(['ket' => $request->ket]);

        return redirect()->back()->with('success', 'Data kematian WUS/PUS berhasil diperbarui');
    }

    // DELETE - PERBAIKAN
    public function destroy($id)
    {
        // Cari berdasarkan id tabel wuspus_kematians
        $data = WuspusKematian::findOrFail($id);
        
        $id_wuspus = $data->id_wuspus;
        $data->delete();

        // Ubah status WUS/PUS jadi aktif lagi
        Wuspus::where('id_wuspus', $id_wuspus)->update(['status' => 'Aktif']);

        return redirect()->back()->with('success', 'Data kematian berhasil dihapus');
    }
}