<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BeritaController extends Controller
{
    public function index()
    {
        return Inertia::render('berita/Berita', [
            'title' => 'Berita',
            'berita' => Berita::all(),
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
        ]);

        Berita::create($validated);

        return redirect()->route('berita')->with('success', 'Berita berhasil ditambahkan.');
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
        ]);

        $berita->update($validated);

        return redirect()->route('berita')->with('success', 'Berita berhasil diubah.');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->delete();

        return redirect()->route('berita')->with('success', 'Berita berhasil dihapus.');
    }
}
