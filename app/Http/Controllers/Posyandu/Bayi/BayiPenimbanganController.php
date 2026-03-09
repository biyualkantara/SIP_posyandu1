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
            $query->where('b.nama_bayi','like',"%{$q}%");
        }

        $data = $query->paginate(20)->withQueryString();

        return Inertia::render('bayi/penimbangan/Index', [
            'data' => $data,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'posyandu' => $posyandu,
            'filter' => compact('kec','kel','pos','q'),
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
            'posyandu_id' => 'required',
            'rows' => 'required|array|min:1',
            'rows.*.id_bayi' => 'required|exists:bayi,id_bayi',
            'rows.*.tgl_pnb' => 'required|date',
            'rows.*.berat' => 'nullable|numeric',
            'rows.*.tb' => 'nullable|numeric',
        ]);

        DB::transaction(function() use ($request){
            foreach($request->rows as $r){
                BayiPnb::create([
                    'id_bayi' => $r['id_bayi'],
                    'tgl_pnb' => $r['tgl_pnb'],
                    'berat' => isset($r['berat']) && $r['berat'] !== '' ? (float)$r['berat'] : null,
                    'tb' => isset($r['tb']) && $r['tb'] !== '' ? (float)$r['tb'] : null,
                    'hasil' => $r['hasil'] ?? null,
                    'pmt' => $r['pmt'] ?? null,
                    'ket' => $r['ket'] ?? null,
                ]);
            }
        });

        return redirect('/posyandu/bayi-pnb')->with('success','Data penimbangan bayi tersimpan');
    }

    public function show($id)
    {
        $row = DB::table('bayi_pnb as p')
            ->leftJoin('bayi as b', 'b.id_bayi', '=', 'p.id_bayi')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->where('p.id_bayi_pnb', $id)
            ->select(
                'p.*', 
                'b.nama_bayi', 
                'w.nik_wuspus',     
                'w.nama_wuspus',     
                'd.nama_posyandu',
                'kel.nama_kel',
                'kec.nama_kec'
            )
            ->first();

        abort_if(!$row, 404);

        return Inertia::render('bayi/penimbangan/Show', ['row' => $row]);
    }

    public function edit($id)
    {
        // Cek apakah user login
        if (!auth()->check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $row = DB::table('bayi_pnb as p')
            ->leftJoin('bayi as b', 'b.id_bayi', '=', 'p.id_bayi')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->where('p.id_bayi_pnb', $id)
            ->select([
                'p.id_bayi_pnb',
                'p.id_bayi',
                'p.tgl_pnb',
                'p.berat',
                'p.tb',
                'p.hasil',
                'p.ket',
                
                'b.nama_bayi',
                
                'w.nama_wuspus',
                'w.nik_wuspus',
                
                'd.nama_posyandu',
                
                'kel.nama_kel',
                
                'kec.nama_kec',
            ])
            ->first();

        abort_if(!$row, 404);

        // Set default values jika null
        $row->nama_kec = $row->nama_kec ?? '-';
        $row->nama_kel = $row->nama_kel ?? '-';
        $row->nama_posyandu = $row->nama_posyandu ?? '-';
        $row->nama_bayi = $row->nama_bayi ?? '-';
        $row->nama_wuspus = $row->nama_wuspus ?? '-';
        $row->nik_wuspus = $row->nik_wuspus ?? '-';

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
            
        $bayi = DB::table('bayi as b')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->select('b.id_bayi', 'b.nama_bayi', 'w.id_posyandu')
            ->get()
            ->groupBy('id_posyandu');
            
        return Inertia::render('bayi/penimbangan/Edit', [
            'row' => $row,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'posyandu' => $posyandu,
            'bayi' => $bayi
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tgl_pnb' => 'required|date',
            'berat' => 'required|numeric',
            'tb' => 'nullable|numeric',
            'hasil' => 'nullable|string',
            'ket' => 'nullable|string',
        ]);

        BayiPnb::where('id_bayi_pnb', $id)->update([
            'tgl_pnb' => $request->tgl_pnb,
            'berat' => $request->berat,
            'tb' => $request->tb,
            'hasil' => $request->hasil,
            'ket' => $request->ket,
        ]);

        return redirect('/posyandu/bayi-pnb')->with('success', 'Data penimbangan bayi berhasil diperbarui');
    }

    public function destroy($id)
    {
        BayiPnb::where('id_bayi_pnb', $id)->delete();
        return back()->with('success', 'Data penimbangan bayi berhasil dihapus');
    }
}