<?php

namespace App\Http\Controllers;

use App\Models\Duspy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;
class DuspyController extends Controller
{
    public function index(Request $request)
    {
        $kecamatan = DB::table('kcmtn')
            ->select('id_kec', 'nama_kec')
            ->orderBy('nama_kec')
            ->get();

        $kelurahanGrouped = DB::table('klrhn')
            ->select('id_kel', 'id_kec', 'nama_kel')
            ->orderBy('nama_kel')
            ->get()
            ->groupBy('id_kec');

        $query = Duspy::query();

        if ($request->filled('kec')) {
            $kec = $request->kec;
            $query->whereHas('kelurahan', function ($q) use ($kec) {
                $q->where('id_kec', $kec);
            });
        }

        if ($request->filled('kel')) {
            $query->where('id_kel', $request->kel);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('nama_posyandu', 'like', "%{$q}%");
        }

        $data = $query
            ->with(['kelurahan.kecamatan'])
            ->orderByDesc('id_posyandu') 
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('posyandu/data-umum/Index', [
            'data' => $data,
            'kecamatan' => $kecamatan,
            'kelurahanGrouped' => $kelurahanGrouped,
            'filter' => [
                'kec' => $request->kec ?? '',
                'kel' => $request->kel ?? '',
                'q'   => $request->q ?? '',
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('posyandu/data-umum/Create', [
            'kecamatan' => DB::table('kcmtn')
                ->select('id_kec', 'nama_kec')
                ->orderBy('nama_kec')
                ->get(),

            'kelurahan' => DB::table('klrhn')
                ->select('id_kel', 'id_kec', 'nama_kel')
                ->orderBy('nama_kel')
                ->get()
                ->groupBy('id_kec'),
        ]);
    }

    public function storeMultiple(Request $request)
    {
        $validated = $request->validate([
            'rows' => 'required|array|min:1',

            'rows.*.id_kel' => 'required|exists:klrhn,id_kel',
            'rows.*.nama_posyandu' => 'required|string|max:150',
            'rows.*.strata_psy' => 'required|string|max:50',
            'rows.*.alamat_posyandu' => 'required|string|max:255',

            'rows.*.pj_umum' => 'required|string|max:100',
            'rows.*.pj_operasional' => 'required|string|max:100',
            'rows.*.ketuplak' => 'required|string|max:100',
            'rows.*.sekretaris' => 'required|string|max:100',

            'rows.*.int_paud' => 'required|integer|in:0,1',
            'rows.*.int_bkd' => 'required|integer|in:0,1',
            'rows.*.int_terpadu' => 'required|integer|in:0,1',

            'rows.*.kader_aktif' => 'required|integer|min:0',
            'rows.*.kader_taktif' => 'required|integer|min:0',

            'rows.*.ptgs_kb' => 'required|string|max:100',
            'rows.*.ptgs_medis' => 'required|string|max:100',
            'rows.*.ptgs_bidan' => 'required|string|max:100',
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['rows'] as $row) {
                Duspy::create($row);
            }
        });

        return redirect()
            ->route('posyandu.data-umum.index')
            ->with('success', 'Data posyandu berhasil ditambahkan');
    }

    public function show($id)
    {
        $duspy = Duspy::with(['kelurahan.kecamatan'])->findOrFail($id);

        return Inertia::render('posyandu/data-umum/Show', [
            'duspy' => $duspy
        ]);
    }

    public function edit($id)
    {
        $duspy = Duspy::with(['kelurahan.kecamatan'])->findOrFail($id);

        return Inertia::render('posyandu/data-umum/Edit', [
            'duspy' => $duspy,

            'kecamatan' => DB::table('kcmtn')
                ->select('id_kec', 'nama_kec')
                ->orderBy('nama_kec')
                ->get(),

            'kelurahan' => DB::table('klrhn')
                ->select('id_kel', 'id_kec', 'nama_kel')
                ->orderBy('nama_kel')
                ->get()
                ->groupBy('id_kec'),
        ]);
    }

    public function update(Request $request, $id)
    {
        $duspy = Duspy::findOrFail($id);

        $validated = $request->validate([
            'id_kel'         => 'required|integer|exists:klrhn,id_kel',
            'nama_posyandu'  => 'required|string|max:150',
            'strata_psy'     => 'nullable|string|max:50',
            'alamat_posyandu'=> 'nullable|string|max:255',

            'pj_umum'        => 'nullable|string|max:100',
            'pj_operasional' => 'nullable|string|max:100',
            'ketuplak'       => 'nullable|string|max:100',
            'sekretaris'     => 'nullable|string|max:100',

            'int_paud'       => 'nullable|integer|in:0,1',
            'int_bkd'        => 'nullable|integer|in:0,1',
            'int_terpadu'    => 'nullable|integer|in:0,1',

            'kader_aktif'    => 'nullable|integer|min:0',
            'kader_taktif'   => 'nullable|integer|min:0',

            'ptgs_kb'        => 'nullable|string|max:100',
            'ptgs_medis'     => 'nullable|string|max:100',
            'ptgs_bidan'     => 'nullable|string|max:100',
        ]);

        $duspy->update($validated);

        return redirect()
            ->route('posyandu.data-umum.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

   /* public function exportPdf()
    {
        $items = Duspy::with(['kelurahan.kecamatan'])
            ->orderBy('nama_posyandu')
            ->get();

        $html = view('pdf.duspy', [
            'items' => $items
        ])->render();

        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return response($dompdf->output(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition'=> 'attachment; filename="data_posyandu.pdf"',
        ]);
    }*/
    public function destroy($id)
    {
        Duspy::findOrFail($id)->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }
}