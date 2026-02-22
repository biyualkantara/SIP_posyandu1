<?php

namespace App\Http\Controllers\Posyandu\Bayi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\BayiWafat;

class BayiWafatController extends Controller
{
    public function index(Request $request)
    {
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

        // data utama: bayi_wafat -> bayi -> wuspus -> duspy -> klrhn -> kcmtn
        $query = DB::table('bayi_wafat as bw')
            ->leftJoin('bayi as b', 'b.id_bayi', '=', 'bw.id_bayi')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->select([
                'bw.id_wafat',
                'bw.id_bayi',
                'bw.tgl_kematian',
                'bw.ket',

                'b.nama_bayi',

                'w.id_posyandu',
                'd.nama_posyandu',

                'kel.id_kel',
                'kel.nama_kel',

                'kec.id_kec',
                'kec.nama_kec',
            ])
            ->orderByDesc('bw.tgl_kematian')
            ->orderByDesc('bw.id_wafat');

        if ($kec !== '') $query->where('kec.id_kec', $kec);
        if ($kel !== '') $query->where('kel.id_kel', $kel);
        if ($pos !== '') $query->where('d.id_posyandu', $pos);

        if ($q !== '') {
            $query->where(function ($x) use ($q) {
                $x->where('b.nama_bayi', 'like', "%{$q}%")
                  ->orWhere('d.nama_posyandu', 'like', "%{$q}%")
                  ->orWhere('bw.ket', 'like', "%{$q}%");
            });
        }

        $data = $query->paginate(20)->withQueryString();

        return Inertia::render('bayi/wafat/Index', [
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

        // BAYI dikelompokkan per posyandu (lewat bayi->wuspus->posyandu)
        $bayi = DB::table('bayi as b')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->select([
                'b.id_bayi',
                'b.nama_bayi',
                'w.id_posyandu',
            ])
            ->orderBy('b.nama_bayi')
            ->get()
            ->groupBy('id_posyandu');

        return Inertia::render('bayi/wafat/Create', [
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'posyandu'  => $posyandu,
            'bayi'      => $bayi,
        ]);
    }

    public function storeMultiple(Request $request)
    {
        $request->validate([
            'kecamatan_id' => ['nullable'],
            'kelurahan_id' => ['required'],
            'posyandu_id'  => ['required'],
            'rows' => ['required', 'array', 'min:1'],

            'rows.*.id_bayi' => ['required', 'integer', 'exists:bayi,id_bayi'],
            'rows.*.tgl_kematian' => ['required', 'date'],
            'rows.*.ket' => ['nullable', 'string'],
        ]);

        $rows = $request->input('rows', []);

        DB::beginTransaction();
        try {
            foreach ($rows as $r) {
                DB::table('bayi_wafat')->insert([
                    'id_bayi' => (int)($r['id_bayi']),
                    'tgl_kematian' => $r['tgl_kematian'],
                    'ket' => $r['ket'] ?? null,
                ]);
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect('/posyandu/bayi-wafat')->with('success', 'Data kematian bayi berhasil disimpan');
    }

    public function show($id)
    {
        $row = DB::table('bayi_wafat as bw')
            ->leftJoin('bayi as b', 'b.id_bayi', '=', 'bw.id_bayi')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->where('bw.id_wafat', $id)
            ->select([
                'bw.*',
                'b.nama_bayi',
                'd.nama_posyandu',
                'kel.nama_kel',
                'kec.nama_kec',
            ])
            ->first();

        abort_if(!$row, 404);

        return Inertia::render('bayi/wafat/Show', ['row' => $row]);
    }

    public function edit($id)
    {
        $row = DB::table('bayi_wafat as bw')
            ->leftJoin('bayi as b', 'b.id_bayi', '=', 'bw.id_bayi')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'w.id_posyandu')
            ->leftJoin('klrhn as kel', 'kel.id_kel', '=', 'd.id_kel')
            ->leftJoin('kcmtn as kec', 'kec.id_kec', '=', 'kel.id_kec')
            ->select([
                'bw.*',
                'b.nama_bayi',

                'w.id_posyandu',
                'd.id_kel',
                'kel.id_kec',

                'kec.nama_kec',
                'kel.nama_kel',
                'd.nama_posyandu',
            ])
            ->where('bw.id_wafat', $id)
            ->first();

        abort_if(!$row, 404);

        $kecamatan = DB::table('kcmtn')->select('id_kec', 'nama_kec')->orderBy('nama_kec')->get();
        $kelurahan = DB::table('klrhn')->select('id_kel', 'id_kec', 'nama_kel')->orderBy('nama_kel')->get()->groupBy('id_kec');
        $posyandu  = DB::table('duspy')->select('id_posyandu', 'id_kel', 'nama_posyandu')->orderBy('nama_posyandu')->get()->groupBy('id_kel');

        $bayi = DB::table('bayi as b')
            ->leftJoin('wuspus as w', 'w.id_wuspus', '=', 'b.id_wuspus')
            ->select([
                'b.id_bayi',
                'b.nama_bayi',
                'w.id_posyandu',
            ])
            ->orderBy('b.nama_bayi')
            ->get()
            ->groupBy('id_posyandu');

        return Inertia::render('bayi/wafat/Edit', [
            'row' => $row,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'posyandu'  => $posyandu,
            'bayi'      => $bayi,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_bayi' => ['required', 'integer', 'exists:bayi,id_bayi'],
            'tgl_kematian' => ['required', 'date'],
            'ket' => ['nullable', 'string'],
        ]);

        BayiWafat::where('id_wafat', $id)->update([
            'id_bayi' => (int)$request->id_bayi,
            'tgl_kematian' => $request->tgl_kematian,
            'ket' => $request->ket,
        ]);

        return redirect('/posyandu/bayi-wafat')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        BayiWafat::where('id_wafat', $id)->delete();
        return redirect('/posyandu/bayi-wafat')->with('success', 'Data berhasil dihapus');
    }
}