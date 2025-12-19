<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class SipintarChatbotController extends Controller
{
    /**
     * VIEW HALAMAN CHATBOT (MENAMPILKAN VUE)
     */
    public function index()
    {
        return Inertia::render('sipintar/chatbot/Index');
    }

    /**
     * API CHATBOT (PILIH MENU)
     */
    public function handle(Request $request)
    {
        $node = $request->input('node', 'root');
        $name = $request->input('name', 'Pengguna');

        // Pohon dialog chatbot
        $tree = [
            'root' => [
                'messages' => [
                    "Hallo {$name}!",
                    "Terima kasih {$name} telah menghubungi chat bot SiPintar.\nBoleh saya tahu masalahnya?"
                ],
                'menu' => [
                    ['id' => 'lihat-bayi',   'label' => 'Cara Melihat Data Bayi'],
                    ['id' => 'hapus-bayi',   'label' => 'Cara Menghapus Data Bayi'],
                    ['id' => 'edit-data',    'label' => 'Cara Mengedit Data'],
                    ['id' => 'laporan',      'label' => 'Cara Melihat Laporan SIP'],
                    ['id' => 'akun',         'label' => 'Masalah Akun & Login'],
                    ['id' => 'lainnya',      'label' => 'Masalah Lainnya'],
                ],
            ],

            'lihat-bayi' => [
                'messages' => [
                    "Berikut cara melihat data bayi:\n".
                    "1. Masuk ke menu Data Umum Posyandu → Registrasi Bayi.\n".
                    "2. Pilih Posyandu yang sesuai.\n".
                    "3. Data bayi tampil pada tabel.\n".
                    "4. Gunakan pencarian untuk nama/NIK.\n".
                    "5. Jika tidak muncul, cek filter & hak akses."
                ],
                'menu' => [
                    ['id' => 'filter-bayi', 'label' => 'Data bayi tidak muncul'],
                    ['id' => 'root',        'label' => 'Kembali ke menu utama'],
                ],
            ],

            'filter-bayi' => [
                'messages' => [
                    "Jika data bayi tidak muncul:\n".
                    "1. Cek Posyandu di filter kiri atas.\n".
                    "2. Atur periode bulan & tahun.\n".
                    "3. Pastikan hak akses Anda mencakup Posyandu tsb.\n".
                    "4. Jika masih tidak muncul, hubungi operator kecamatan."
                ],
                'menu' => [
                    ['id' => 'root', 'label' => 'Kembali ke menu utama'],
                ],
            ],

            'hapus-bayi' => [
                'messages' => [
                    "Cara menghapus data bayi:\n".
                    "1. Buka Registrasi Bayi.\n".
                    "2. Cari bayi yang ingin dihapus.\n".
                    "3. Klik ikon tempat sampah.\n".
                    "4. Konfirmasi penghapusan.\n".
                    "5. Data yang dihapus tidak bisa dikembalikan."
                ],
                'menu' => [
                    ['id' => 'root', 'label' => 'Kembali ke menu utama'],
                ],
            ],

            'edit-data' => [
                'messages' => [
                    "Cara mengedit data:\n".
                    "1. Masuk ke menu data (Bayi/Bumil/WUS-PUS).\n".
                    "2. Klik ikon Pensil/Edit.\n".
                    "3. Perbarui data.\n".
                    "4. Klik Simpan.\n".
                    "5. Perubahan terekam otomatis."
                ],
                'menu' => [
                    ['id' => 'root', 'label' => 'Kembali ke menu utama'],
                ],
            ],

            'laporan' => [
                'messages' => [
                    "Cara melihat dan mengunduh laporan SIP:\n".
                    "1. Masuk Rekapitulasi SIP.\n".
                    "2. Pilih format laporan (1–5).\n".
                    "3. Atur bulan & tahun.\n".
                    "4. Klik Tampilkan.\n".
                    "5. Export PDF/Excel bila diperlukan."
                ],
                'menu' => [
                    ['id' => 'root', 'label' => 'Kembali ke menu utama'],
                ],
            ],

            'akun' => [
                'messages' => [
                    "Masalah akun yang sering terjadi:\n".
                    "1. Lupa password → hubungi operator kecamatan.\n".
                    "2. Gagal login → cek username/password (case-sensitive).\n".
                    "3. Akun terkunci → tunggu 15 menit atau hubungi admin."
                ],
                'menu' => [
                    ['id' => 'root', 'label' => 'Kembali ke menu utama'],
                ],
            ],

            'lainnya' => [
                'messages' => [
                    "Untuk masalah lainnya:\n".
                    "• Laporkan ke operator Posyandu.\n".
                    "• Sertakan screenshot & waktu kejadian.\n".
                    "• Foto lengkap pesan error jika muncul."
                ],
                'menu' => [
                    ['id' => 'root', 'label' => 'Kembali ke menu utama'],
                ],
            ],
        ];

        // Jika node tidak ditemukan
        if (!isset($tree[$node])) {
            return response()->json([
                'node' => 'root',
                'messages' => [
                    "Maaf, saya belum memahami pertanyaan ini.",
                    "Silakan pilih kembali dari menu utama."
                ],
                'menu' => $tree['root']['menu'],
            ]);
        }

        // Response normal
        return response()->json([
            'node' => $node,
            'messages' => $tree[$node]['messages'],
            'menu' => $tree[$node]['menu'],
        ]);
    }
}