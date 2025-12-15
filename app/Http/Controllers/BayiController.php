<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Bayi;
use App\Models\BayiImun;
use App\Models\BayiPnb;
use App\Models\BayiWafat;
use App\Models\DataBayi;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Duspy;
use App\Models\Wuspus;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BayiController extends Controller
{
    public function showBiodataView() {
        $bayi = Bayi::select('id_bayi', 'duspy.nama_posyandu', 'nama_bayi', 'jk', 'tgl_lhr', 'bb', 'wuspus.nama_wuspus', 'wuspus.nama_suami')
            ->join('wuspus', 'bayi.id_wuspus', '=', 'wuspus.id_wuspus')
            ->join('duspy', 'wuspus.id_posyandu', '=', 'duspy.id_posyandu')
            ->get();
        return Inertia::render("bayi/Biodata", [
            "bayi" => $bayi
        ]);
    }

    public function showAddBiodataView() {
        return Inertia::render('bayi/AddBiodata', [
            "kecamatan" => Kecamatan::all(),
            "kelurahan" => Kelurahan::all()->groupBy('id_kec'),
            "posyandu" => Duspy::all()->groupBy("id_kel"),
            "wuspus" => Wuspus::all()->groupBy("id_posyandu"),
        ]);
    }

    public function handlePostBiodata(Request $request)
    {
        $validated = $request->validate([
            'kecamatan_id'        => 'required',
            'kelurahan_id'        => 'required',
            'posyandu_id'         => 'required',
            'rows'                => ['required', 'array'],
            'rows.*.tanggal_daftar'  => ['required', 'date'],
            'rows.*.id_wuspus'       => ['required', 'integer'],
            'rows.*.nama_bayi'       => ['required', 'string'],
            'rows.*.jenis_kelamin'   => ['required', 'in:L,P'],
            'rows.*.tanggal_lahir'   => ['required', 'date'],
            'rows.*.bbl'             => ['required', 'numeric'],
            'rows.*.keterangan'      => ['nullable', 'string'],
        ]);

        $createdIds = [];

        foreach ($validated['rows'] as $row) {
            /** @var \App\Models\Bayi $bayi */
            $bayi = Bayi::create([
                'id_wuspus'   => $row['id_wuspus'],
                'tgl_daftar'  => $row['tanggal_daftar'],
                'nama_bayi'   => $row['nama_bayi'],
                'jk'          => $row['jenis_kelamin'],
                'tgl_lhr'     => $row['tanggal_lahir'],
                'bb'          => $row['bbl'],
                'ket'         => $row['keterangan'] ?? null,
            ]);

            $idBayi = $bayi->id_bayi ?? $bayi->id ?? null;

            if ($idBayi) {
                $createdIds[] = $idBayi;

                // ai dijalankan
                app(\App\Http\Controllers\AiStuntingPredictController::class)
                    ->predictForBaby((int) $idBayi);
            }
        }

        return redirect('/data_bayi/biodata')
            ->with('success', 'Data bayi & prediksi AI berhasil disimpan.');
    }

    public function showEditBiodataView(Request $request, $id) {
        $bayi = Bayi::findOrFail($id);
        return Inertia::render('bayi/EditBiodata', [
            "bayi" => $bayi,
            "orang_tua" => Wuspus::find($bayi->id_wuspus)
        ]);
    }

    public function handleUpdateBiodata(Request $request, $id)
    {
        /** @var \App\Models\Bayi $bayi */
        $bayi = Bayi::findOrFail($id);

        $validated = $request->validate([
            'tanggal_daftar'  => ['required', 'date'],
            'id_wuspus'       => ['required', 'integer'],
            'nama_bayi'       => ['required', 'string'],
            'jenis_kelamin'   => ['required', 'in:L,P'],
            'tanggal_lahir'   => ['required', 'date'],
            'bbl'             => ['required', 'numeric'],
            'keterangan'      => ['nullable', 'string'],
        ]);

        $bayi->update([
            'tgl_daftar'  => $validated['tanggal_daftar'],
            'id_wuspus'   => $validated['id_wuspus'],
            'nama_bayi'   => $validated['nama_bayi'],
            'jk'          => $validated['jenis_kelamin'],
            'tgl_lhr'     => $validated['tanggal_lahir'],
            'bb'          => $validated['bbl'],
            'ket'         => $validated['keterangan'] ?? null,
        ]);

        // jalankan Ai ke bayi ini
        $idBayi = $bayi->id_bayi ?? $bayi->id;
        app(\App\Http\Controllers\AiStuntingPredictController::class)
            ->predictForBaby((int) $idBayi);

        return redirect('/data_bayi/biodata')
            ->with('success', 'Data bayi & prediksi AI berhasil diperbarui.');
    }

    public function handleDeleteBiodata(Request $request, $id)
    {
        /** @var \App\Models\Bayi $bayi */
        $bayi = Bayi::findOrFail($id);

        // Hapus prediksi AI dulu
        \DB::table('ai_stunting_prediction')
            ->where('id_bayi', $id)
            ->delete();

        $bayi->delete();

        return redirect('/data_bayi/biodata')
            ->with('success', 'Data bayi & prediksi AI berhasil dihapus.');
    }

    public function showPenimbanganView() {
        return Inertia::render("bayi/Penimbangan", [
            "penimbangan" => BayiPnb::select(
                    "id_bayi_pnb",
                    "duspy.nama_posyandu", 
                    \DB::raw("CONCAT(wuspus.nama_wuspus, ' & ', wuspus.nama_suami) AS nama_orang_tua"),
                    "bayi.nama_bayi", 
                    "bayi_pnb.tgl_pnb",
                    "bayi_pnb.berat",
                    "bayi_pnb.tb",
                    "wuspus.tinggi_ayah",
                    "wuspus.tinggi_ibu",
                    "bayi_pnb.ket"
            )
            ->join('bayi', 'bayi_pnb.id_bayi', '=', 'bayi.id_bayi')
            ->join('wuspus', 'bayi.id_wuspus', 'wuspus.id_wuspus')
            ->join('duspy', 'wuspus.id_posyandu', 'duspy.id_posyandu')
            ->get()
        ]);
    }

    public function showAddPenimbanganView() {
        return Inertia::render('bayi/AddPenimbangan', [
            "kecamatan" => Kecamatan::all(),
            "kelurahan" => Kelurahan::all()->groupBy('id_kec'),
            "posyandu" => Duspy::all()->groupBy("id_kel"),
            "wuspus" => Wuspus::all()->groupBy("id_posyandu"),
            "bayi" => Bayi::all()->groupBy("id_wuspus"),
        ]);
    }

    public function handlePostPenimbangan(Request $request)
    {
    //     tanggal_penimbangan: '',
    //   berat: '',
    //   hasil: '',
    //   pmt: '',
    //   keterangan: ''
        $validated = $request->validate([
            'kecamatan_id'        => 'required',
            'kelurahan_id'        => 'required',
            'posyandu_id'         => 'required',
            'wuspus_id'           => 'required',
            'bayi_id'             => 'required',
            'rows'                => ['required', 'array'],
            'rows.*.tanggal_penimbangan'  => ['required', 'date'],
            'rows.*.berat'             => ['required', 'numeric'],
            'rows.*.hasil'             => ['required', 'string'],
            'rows.*.pmt'                => ['required', 'string'],
            'rows.*.ket'              => ['nullable', 'string'],
        ]);

        foreach ($validated['rows'] as $row) {
            BayiPnb::create([
                'id_bayi'      => $validated['bayi_id'],
                'tgl_pnb'      => $row['tanggal_penimbangan'],
                'berat'        => $row['berat'],
                'hasil'        => $row['hasil'],
                'pmt'          => $row['pmt'],
                'ket'          => $row['keterangan'] ?? null,
            ]);
        }

        return redirect('/data_bayi/penimbangan')
            ->with('success', 'Data penimbangan berhasil disimpan.');
    }

    public function showEditPenimbanganView(Request $request, $id) {
        $penimbangan = BayiPnb::findOrFail($id);
        return Inertia::render('bayi/EditPenimbangan', [
            "penimbangan" => $penimbangan,
            "bayi" => Bayi::find($penimbangan->id_bayi),
            "wuspus" => Wuspus::find(Bayi::find($penimbangan->id_bayi)->id_wuspus),
        ]);
    }

    public function handleUpdatePenimbangan(Request $request, $id)
    {
        /** @var \App\Models\BayiPnb $penimbangan */
        $penimbangan = BayiPnb::findOrFail($id);

        $validated = $request->validate([
            'tanggal_penimbangan'  => ['required', 'date'],
            'berat'             => ['required', 'numeric'],
            'hasil'             => ['required', 'string'],
            'pmt'                => ['required', 'string'],
            'keterangan'      => ['nullable', 'string'],
        ]);

        $penimbangan->update([
            'tgl_pnb'      => $validated['tanggal_penimbangan'],
            'berat'        => $validated['berat'],
            'hasil'        => $validated['hasil'],
            'pmt'          => $validated['pmt'],
            'ket'          => $validated['keterangan'] ?? null,
        ]);

        return redirect('/data_bayi/penimbangan')
            ->with('success', 'Data penimbangan berhasil diperbarui.');
    }

    public function handleDeletePenimbangan(Request $request, $id)
    {
        $penimbangan = BayiPnb::findOrFail($id);

        $penimbangan->delete();

        return redirect('/data_bayi/penimbangan')
            ->with('success', 'Data penimbangan berhasil dihapus.');
    }

    public function showImunisasiView() {
        return Inertia::render("bayi/Imunisasi", [
            "imunisasi" => BayiImun::select([
                    "id_bayi_imun",
                "duspy.nama_posyandu", 
                \DB::raw("CONCAT(wuspus.nama_wuspus, ' & ', wuspus.nama_suami) AS nama_orang_tua"),
                "bayi.nama_bayi", 
                "bayi_imun.tgl_imun",
                "imunisasi.kd_imun",
                "bayi_imun.ket"
            ])->join('bayi', 'bayi_imun.id_bayi', '=', 'bayi.id_bayi')
            ->join('imunisasi', 'bayi_imun.id_imun', '=','imunisasi.id_imun')
            ->join('wuspus', 'bayi.id_wuspus', 'wuspus.id_wuspus')
            ->join('duspy', 'wuspus.id_posyandu', 'duspy.id_posyandu')
            ->get()
        ]);
    }

    public function showAddImunisasiView() {
        return Inertia::render('bayi/AddImunisasi', [
            "kecamatan" => Kecamatan::all(),
            "kelurahan" => Kelurahan::all()->groupBy('id_kec'),
            "posyandu" => Duspy::all()->groupBy("id_kel"),
            "wuspus" => Wuspus::all()->groupBy("id_posyandu"),
            "bayi" => Bayi::all()->groupBy("id_wuspus"),
            "imunisasi" => \App\Models\Imunisasi::all(),
        ]);
    }

    public function handlePostImunisasi(Request $request) {
        $validated = $request->validate([
            'kecamatan_id'        => 'required',
            'kelurahan_id'        => 'required',
            'posyandu_id'         => 'required',
            'wuspus_id'           => 'required',
            'rows'                => ['required', 'array'],
            'rows.*.id_bayi'           => ['required', 'integer'],
            'rows.*.tanggal_imunisasi'  => ['required', 'date'],
            'rows.*.id_imun'    => ['required', 'integer'],
            'rows.*.keterangan'         => ['nullable', 'string'],
        ]);

        foreach ($validated['rows'] as $row) {
            BayiImun::create([
                'id_bayi'      => $row['id_bayi'],
                'id_imun'      => $row['id_imun'],
                'tgl_imun'     => $row['tanggal_imunisasi'],
                'ket'          => $row['keterangan'] ?? null,
            ]);
        }

        return redirect('/data_bayi/imunisasi')
            ->with('success', 'Data imunisasi berhasil disimpan.');
    }

    public function showEditImunisasiView($id) {
        $imunisasi = BayiImun::findOrFail($id);
        return Inertia::render('bayi/EditImunisasi', [
            "imunisasi" => $imunisasi,
            "bayi" => Bayi::find($imunisasi->id_bayi),
            "orang_tua" => Wuspus::find(Bayi::find($imunisasi->id_bayi)->id_wuspus),
            "daftar_imunisasi" => \App\Models\Imunisasi::all(),
        ]);
    }

    public function handleUpdateImunisasi(Request $request, $id) {
        $imunisasi = BayiImun::findOrFail($id);

        $validated = $request->validate([
            'tanggal_imunisasi'  => ['required', 'date'],
            'id_imun'           => ['required', 'integer'],
            'keterangan'      => ['nullable', 'string'],
        ]);

        $imunisasi->update([
            'tgl_imun'     => $validated['tanggal_imunisasi'],
            'id_imun'      => $validated['id_imun'],
            'ket'          => $validated['keterangan'] ?? null,
        ]);

        return redirect('/data_bayi/imunisasi')
            ->with('success', 'Data imunisasi berhasil diperbarui.');
    }

    public function handleDeleteImunisasi(Request $request, $id) {
        /** @var \App\Models\BayiImun $imunisasi */
        $imunisasi = BayiImun::findOrFail($id);

        $imunisasi->delete();

        return redirect('/data_bayi/imunisasi')
            ->with('success', 'Data imunisasi berhasil dihapus.');
    }

    public function showKematianView() {
        return Inertia::render("bayi/Kematian", [
            "kematian" => BayiWafat::select([
                "id_wafat",
                "duspy.nama_posyandu", 
                \DB::raw("CONCAT(wuspus.nama_wuspus, ' & ', wuspus.nama_suami) AS nama_orang_tua"),
                "bayi.nama_bayi", 
                "bayi_wafat.tgl_kematian",
                "bayi_wafat.ket"
            ])->join('bayi', 'bayi_wafat.id_bayi', '=', 'bayi.id_bayi')
            ->join('wuspus', 'bayi.id_wuspus', 'wuspus.id_wuspus')
            ->join('duspy', 'wuspus.id_posyandu', 'duspy.id_posyandu')
            ->get()
        ]);
    }

    public function showAddKematianView() {
        return Inertia::render('bayi/AddKematian', [
            "kecamatan" => Kecamatan::all(),
            "kelurahan" => Kelurahan::all()->groupBy('id_kec'),
            "posyandu" => Duspy::all()->groupBy("id_kel"),
            "wuspus" => Wuspus::all()->groupBy("id_posyandu"),
            "bayi" => Bayi::all()
        ]);
    }

    public function handlePostKematian(Request $request) {
        $validated = $request->validate([
            'kecamatan_id'        => 'required',
            'kelurahan_id'        => 'required',
            'posyandu_id'         => 'required',
            'rows'                => ['required', 'array'],
            'rows.*.id_bayi'           => ['required', 'integer'],
            'rows.*.tanggal_kematian'  => ['required', 'date'],
            'rows.*.keterangan'         => ['nullable', 'string'],
        ]);
        

        foreach ($validated['rows'] as $row) {
            BayiWafat::create([
                'id_bayi'      => $row['id_bayi'],
                'tgl_kematian'     => $row['tanggal_kematian'],
                'ket'          => $row['keterangan'] ?? null,
            ]);
        }

        return redirect('/data_bayi/kematian')
            ->with('success', 'Data kematian bayi berhasil disimpan.');
    }

    public function showEditKematianView($id) {
        $kematian = BayiWafat::findOrFail($id);
        return Inertia::render('bayi/EditKematian', [
            "kematian" => $kematian
        ]);
    }

    public function handleUpdateKematian(Request $request, $id) {
        $kematian = BayiWafat::findOrFail($id);

        $validated = $request->validate([
            'tanggal_kematian'  => ['required', 'date'],
            'keterangan'      => ['nullable', 'string'],
        ]);

        $kematian->update([
            'tgl_kematian'     => $validated['tanggal_kematian'],
            'ket'          => $validated['keterangan'] ?? null,
        ]);

        return redirect('/data_bayi/kematian')
            ->with('success', 'Data kematian bayi berhasil diperbarui.');
    }

    public function handleDeleteKematian(Request $request, $id) {
        $kematian = BayiWafat::findOrFail($id);

        $kematian->delete();

        return redirect('/data_bayi/kematian')
            ->with('success', 'Data kematian bayi berhasil dihapus.');
    }

}