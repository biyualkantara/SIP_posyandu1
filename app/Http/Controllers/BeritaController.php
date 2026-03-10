<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class BeritaController extends Controller
{
    public function index()
    {
        // Ambil semua berita
        $berita = Berita::orderBy('tanggal_waktu', 'desc')->paginate(10);
        
        // Log untuk debugging
        Log::info('Data berita:', [
            'total' => $berita->total(),
            'data' => $berita->toArray()
        ]);
        
        return Inertia::render('berita/Berita', [
            'berita' => $berita,
            'filters' => request()->all(['search', 'kategori'])
        ]);
    }

    public function create()
    {
        return Inertia::render('berita/AddBerita');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'ringkasan' => 'required|string|max:500',
            'isi' => 'required|string',
            'penulis' => 'required|string|max:100',
            'kategori' => 'nullable|string|max:50',
        ]);

        if (empty($validated['kategori'])) {
            $validated['kategori'] = $this->detectKategori($validated['judul'], $validated['ringkasan']);
        }

        $validated['tanggal_waktu'] = now();

        Berita::create($validated);

        return redirect()->route('berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }   

    public function show($id)
    {
        $berita = Berita::findOrFail($id);
        return Inertia::render('berita/Show', [
            'berita' => $berita
        ]);
    }

    public function detail($id)
    {
        $berita = Berita::findOrFail($id);

        return Inertia::render('landingpage/detailberita', [
            'berita' => $berita
        ]);
    }

    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        return Inertia::render('berita/EditBerita', [
            'berita' => $berita,
        ]);
    }

    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'ringkasan' => 'required|string|max:500',
            'isi' => 'required|string',
            'penulis' => 'required|string|max:100',
            'kategori' => 'nullable|string|max:50',
        ]);

        $berita->update($validated);
        return redirect()->route('berita.index')->with('success', 'Berita berhasil diubah.');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->delete();
        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus.');
    }

    private function detectKategori($judul, $ringkasan)
    {
        $text = strtolower($judul . ' ' . $ringkasan);
        
        if (str_contains($text, 'penting') || str_contains($text, 'urgent') || str_contains($text, 'peringatan')) {
            return 'Penting';
        }
        if (str_contains($text, 'kegiatan') || str_contains($text, 'acara') || str_contains($text, 'jadwal')) {
            return 'Kegiatan';
        }
        if (str_contains($text, 'imunisasi') || str_contains($text, 'vaksin') || str_contains($text, 'kesehatan')) {
            return 'Kesehatan';
        }
        return 'Info';
    }
}