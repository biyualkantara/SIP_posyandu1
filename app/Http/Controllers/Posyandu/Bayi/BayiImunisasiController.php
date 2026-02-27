<?php

namespace App\Http\Controllers\Posyandu\Bayi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class BayiImunisasiController extends Controller
{
    public function index(Request $request)
    {
        $kec = $request->kec;
        $kel = $request->kel;
        $pos = $request->pos;
        $q   = $request->q;

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

        $query = DB::table('bayi_imun as bi')
            ->join('bayi as b', 'b.id_bayi', '=', 'bi.id_bayi')
            ->join('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->join('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->join('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->join('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->join('imunisasi as i', 'i.id_imun', '=', 'bi.id_imun')
            ->select(
                'bi.id_bayi_imun',
                'bi.tgl_imun',
                'bi.ket',
                'b.id_bayi',
                'b.nama_bayi',
                'i.jns_imun',
                'd.id_posyandu',
                'd.nama_posyandu',
                'kel.id_kel',
                'kel.nama_kel',
                'kec.id_kec',
                'kec.nama_kec'
            )
            ->when($kec, fn ($x) => $x->where('kec.id_kec', $kec))
            ->when($kel, fn ($x) => $x->where('kel.id_kel', $kel))
            ->when($pos, fn ($x) => $x->where('d.id_posyandu', $pos))
            ->when($q, function ($x) use ($q) {
                $x->where('b.nama_bayi', 'like', "%{$q}%")
                  ->orWhere('i.jns_imun', 'like', "%{$q}%")
                  ->orWhere('d.nama_posyandu', 'like', "%{$q}%");
            })
            ->orderByDesc('bi.id_bayi_imun');

        $data = $query->paginate(10)->withQueryString();

        return Inertia::render('bayi/imunisasi/Index', [
            'data' => $data,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'posyandu' => $posyandu,
            'filter' => compact('kec', 'kel', 'pos', 'q'),
        ]);
    }

    public function create()
    {
        $kecamatan = DB::table('kcmtn')->select('id_kec', 'nama_kec')->orderBy('nama_kec')->get();
        $kelurahan = DB::table('klrhn')->select('id_kel', 'id_kec', 'nama_kel')->orderBy('nama_kel')->get()->groupBy('id_kec');
        $posyandu  = DB::table('duspy')->select('id_posyandu', 'id_kel', 'nama_posyandu')->orderBy('nama_posyandu')->get()->groupBy('id_kel');

        $bayi = DB::table('bayi as b')
            ->join('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->select('b.id_bayi', 'b.nama_bayi', 'w.id_posyandu')
            ->orderBy('b.nama_bayi')
            ->get()
            ->groupBy('id_posyandu');

        $imun = DB::table('imunisasi')->select('id_imun', 'jns_imun')->orderBy('jns_imun')->get();

        return Inertia::render('bayi/imunisasi/Create', compact(
            'kecamatan',
            'kelurahan',
            'posyandu',
            'bayi',
            'imun'
        ));
    }

    // Method untuk single data
    public function store(Request $request)
    {
        $request->validate([
            'id_bayi' => 'required|integer',
            'id_imun' => 'required|integer',
            'tgl_imun' => 'required|date',
            'ket' => 'nullable|string',
        ]);

        DB::table('bayi_imun')->insert([
            'id_bayi' => $request->id_bayi,
            'id_imun' => $request->id_imun,
            'tgl_imun' => $request->tgl_imun,
            'ket' => $request->ket,
        ]);

        return redirect('/posyandu/bayi-imun');
    }

    // Method untuk multi data (tambahkan ini)
    public function storeMultiple(Request $request)
    {
        $request->validate([
            'rows' => 'required|array|min:1',
            'rows.*.id_bayi' => 'required|integer|exists:bayi,id_bayi',
            'rows.*.id_imun' => 'required|integer|exists:imunisasi,id_imun',
            'rows.*.tgl_imun' => 'required|date',
            'rows.*.ket' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->rows as $row) {
                DB::table('bayi_imun')->insert([
                    'id_bayi' => $row['id_bayi'],
                    'id_imun' => $row['id_imun'],
                    'tgl_imun' => $row['tgl_imun'],
                    'ket' => $row['ket'] ?? null,
                ]);
            }
            DB::commit();
            
            return redirect('/posyandu/bayi-imun')
                ->with('success', 'Data imunisasi bayi berhasil disimpan');
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function show($id)
    {
        $row = DB::table('bayi_imun as bi')
            ->join('bayi as b', 'b.id_bayi', '=', 'bi.id_bayi')
            ->join('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->join('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->join('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->join('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->join('imunisasi as i', 'i.id_imun', '=', 'bi.id_imun')
            ->where('bi.id_bayi_imun', $id)
            ->select(
                'bi.*',
                'b.nama_bayi',
                'i.jns_imun',
                'd.nama_posyandu',
                'kel.nama_kel',
                'kec.nama_kec'
            )
            ->first();

        abort_if(!$row, 404);

        return Inertia::render('bayi/imunisasi/Show', compact('row'));
    }

    public function edit($id)
    {
        // Ambil data imunisasi beserta relasinya
        $row = DB::table('bayi_imun as bi')
            ->join('bayi as b', 'b.id_bayi', '=', 'bi.id_bayi')
            ->join('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->join('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->join('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->join('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->where('bi.id_bayi_imun', $id)
            ->select(
                'bi.*',
                'b.id_bayi',
                'b.nama_bayi',
                'w.id_posyandu',
                'd.nama_posyandu',
                'kel.id_kel',
                'kel.nama_kel',
                'kec.id_kec',
                'kec.nama_kec'
            )
            ->first();
        
        abort_if(!$row, 404);

        // Data untuk select box
        $kecamatan = DB::table('kcmtn')->select('id_kec', 'nama_kec')->orderBy('nama_kec')->get();
        $kelurahan = DB::table('klrhn')->select('id_kel', 'id_kec', 'nama_kel')->orderBy('nama_kel')->get()->groupBy('id_kec');
        $posyandu  = DB::table('duspy')->select('id_posyandu', 'id_kel', 'nama_posyandu')->orderBy('nama_posyandu')->get()->groupBy('id_kel');

        $bayi = DB::table('bayi as b')
            ->join('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->select('b.id_bayi', 'b.nama_bayi', 'w.id_posyandu')
            ->orderBy('b.nama_bayi')
            ->get()
            ->groupBy('id_posyandu');

        $imun = DB::table('imunisasi')->select('id_imun', 'jns_imun')->orderBy('jns_imun')->get();

        return Inertia::render('bayi/imunisasi/Edit', [
            'row' => $row, // Sekarang row punya nama_kec, nama_kel, nama_posyandu, nama_bayi
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'posyandu' => $posyandu,
            'bayi' => $bayi,
            'imun' => $imun
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'id_imun' => 'required|integer|exists:imunisasi,id_imun',
                'tgl_imun' => 'required|date',
                'ket' => 'nullable|string',
            ]);

            // Cek apakah data ada
            $exists = DB::table('bayi_imun')->where('id_bayi_imun', $id)->exists();
            
            if (!$exists) {
                return back()->withErrors(['message' => 'Data tidak ditemukan']);
            }

            // Update data (HAPUS 'updated_at' => now())
            DB::table('bayi_imun')
                ->where('id_bayi_imun', $id)
                ->update([
                    'id_imun' => $request->id_imun,
                    'tgl_imun' => $request->tgl_imun,
                    'ket' => $request->ket,
                    // 'updated_at' => now(), // HAPUS baris ini karena kolom tidak ada
                ]);

            return redirect('/posyandu/bayi-imun')
                ->with('success', 'Data imunisasi bayi berhasil diperbarui');
                
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Gagal update: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::table('bayi_imun')->where('id_bayi_imun', $id)->delete();
        return back();
    }
}