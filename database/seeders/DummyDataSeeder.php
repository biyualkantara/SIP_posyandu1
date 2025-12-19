<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // Kecamatan
        DB::table('kcmtn')->insert([
            ['nama_kec' => 'Kecamatan Mekar'],
            ['nama_kec' => 'Kecamatan Sejahtera'],
        ]);

        // Kelurahan
        DB::table('klrhn')->insert([
            ['id_kec' => 1, 'nama_kel' => 'Kelurahan Mawar'],
            ['id_kec' => 1, 'nama_kel' => 'Kelurahan Melati'],
        ]);

        // Posyandu
        DB::table('duspy')->insert([
            ['nama_posyandu' => 'Posyandu Melati', 'alamat_posyandu' => 'Jl. Melati No.10', 'id_kel' => 1, 'strata_psy' => 'Utama', 'pj_umum' => 'Bu Sari'],
            ['nama_posyandu' => 'Posyandu Mawar',  'alamat_posyandu' => 'Jl. Mawar No.2',  'id_kel' => 1, 'strata_psy' => 'Madya', 'pj_umum' => 'Pak Budi'],
        ]);

        // Operator
        DB::table('operator')->insert([
            [
                'username' => 'admin', 'password' => sha1('admin123'), 'nama' => 'Admin Posyandu',
                'alamat' => 'Kantor Posyandu', 'kcmtn' => 1, 'klrhn' => 1, 'id_posyandu' => 1,
                'email' => 'admin@posyandu.local', 'no_hp' => '081234567890'
            ],
            [
                'username' => 'kader1', 'password' => sha1('kader123'), 'nama' => 'Siti Kader',
                'alamat' => 'Rumah Siti', 'kcmtn' => 1, 'klrhn' => 1, 'id_posyandu' => 1,
                'email' => 'siti@posyandu.local', 'no_hp' => '081234567891'
            ],
        ]);

        // Menu
        DB::table('menu')->insert([
            ['menu_uri' => '/dashboard', 'menu_url' => 'dashboard.php', 'menu_allowed' => 'admin,kader', 'parent_id' => null],
            ['menu_uri' => '/data_bayi', 'menu_url' => 'data_bayi.php',  'menu_allowed' => 'admin,kader', 'parent_id' => 1],
        ]);

        // Strata Posyandu
        DB::table('stratapsy')->insert([
            ['strata_posyandu' => 'Utama'],
            ['strata_posyandu' => 'Madya'],
            ['strata_posyandu' => 'Dasar'],
        ]);

        // Level Operator
        DB::table('oplvl')->insert([
            ['lvl_nama' => 'Super Admin'],
            ['lvl_nama' => 'Admin'],
            ['lvl_nama' => 'Kader'],
        ]);

        // Header Kader
        DB::table('kdrhdr')->insert([
            ['id_posyandu' => 1, 'bulan' => 'Januari', 'pkk' => 'PKK A', 'plkb' => 'PLKB A', 'medis' => 'Dr. Siti'],
        ]);

        // Imunisasi Master
        DB::table('imunisasi')->insert([
            ['kd_imun' => 'BCG',   'jns_imun' => 'BCG',   'imun_untuk' => 'Bayi'],
            ['kd_imun' => 'Polio', 'jns_imun' => 'Polio', 'imun_untuk' => 'Bayi'],
            ['kd_imun' => 'DPT',   'jns_imun' => 'DPT',   'imun_untuk' => 'Bayi'],
        ]);

        // WUS/PUS
        DB::table('wuspus')->insert([
            [
                'id_posyandu' => 1,
                'nik_wuspus' => '321001234567890',
                'nama_wuspus' => 'Ibu Ani',
                'umur' => 28,
                'tinggi_ibu' => 156.50,
                'nama_suami' => 'Budi',
                'tinggi_ayah' => 170.00,
                'klmpk_dasawisma' => 'Dasawisma A',
                'jml_anak_hdp' => 1,
                'tgl_daftar' => '2020-05-01',
                'status' => 'Aktif'
            ]
        ]);

        // Kontrasepsi
        DB::table('wuspus_kontrasepsi')->insert([
            [
                'id_wuspus' => 1, 'jns_kontrasepsi' => 'Suntik',
                'tgl_ganti' => '2024-01-01', 'kontrasepsi_baru' => 'Suntik 3 bulan',
                'ket' => 'Keterangan contoh'
            ]
        ]);

        // Bumil
        DB::table('bumil')->insert([
            [
                'id_wuspus' => 1, 'tgl_daftar' => '2024-06-01', 'umur_kehamilan' => 24,
                'hamil_ke' => 2, 'pmt_pemulihan' => 'PMT A', 'lila' => 24.5
            ]
        ]);

        // Penimbangan Bumil
        DB::table('bumil_pnb')->insert([
            [
                'id_wuspus' => 1, 'bln_hamil' => '6 bulan', 'tgl_pnb' => '2024-07-01',
                'berat' => 58.5, 'hasil' => 'Normal', 'ket' => 'Catatan'
            ]
        ]);

        // Bayi
        DB::table('bayi')->insert([
            [
                'id_wuspus' => 1, 'nama_bayi' => 'Rafi', 'jk' => 'L',
                'tgl_lhr' => '2022-03-14', 'bb' => 12.40, 'tb' => 80.0,
                'tb_terkini' => 83.5, 'tgl_daftar' => '2022-03-15'
            ],
            [
                'id_wuspus' => 1, 'nama_bayi' => 'Sinta', 'jk' => 'P',
                'tgl_lhr' => '2023-06-10', 'bb' => 8.50, 'tb' => 72.0,
                'tb_terkini' => 72.5, 'tgl_daftar' => '2023-06-12'
            ],
        ]);

        // Data bayi rekap
        DB::table('data_bayi')->insert([
            [
                'nama_posyandu' => 'Posyandu Melati', 'id_bayi' => 1, 'nama_bayi' => 'Rafi',
                'jk' => 'L', 'tgl_lhr' => '2022-03-14', 'bb' => 12.40, 'tb' => 83.5,
                'nama_wuspus' => 'Ibu Ani', 'nama_suami' => 'Budi'
            ]
        ]);

        // Penimbangan bayi
        DB::table('bayi_pnb')->insert([
            [
                'id_bayi' => 1, 'tgl_pnb' => '2024-01-05', 'berat' => 12.4,
                'tb' => 82.5, 'hasil' => 'Normal', 'pmt' => 'PMT1', 'ket' => 'OK'
            ],
            [
                'id_bayi' => 2, 'tgl_pnb' => '2024-01-05', 'berat' => 8.5,
                'tb' => 72.0, 'hasil' => 'Perlu Pantau', 'pmt' => 'PMT1', 'ket' => 'Pantauan'
            ],
        ]);

        // Imunisasi Bayi
        DB::table('bayi_imun')->insert([
            ['id_bayi' => 1, 'id_imun' => 1, 'tgl_imun' => '2022-05-10', 'ket' => 'BCG pertama'],
            ['id_bayi' => 1, 'id_imun' => 2, 'tgl_imun' => '2022-06-10', 'ket' => 'Polio'],
        ]);

        // Imunisasi WUS
        DB::table('wuspus_imun')->insert([
            ['id_wuspus' => 1, 'id_imun' => 1, 'tgl_imun' => '2024-01-01', 'ket' => 'Imunasi ibu']
        ]);

        // Imunisasi Bumil
        DB::table('bumil_imun')->insert([
            ['id_wuspus' => 1, 'id_imun' => 2, 'tgl_imun' => '2024-02-01', 'ket' => 'Imunasi bumil']
        ]);

        // Format laporan
        DB::table('format_1')->insert([
            [
                'kecamatan' => 'Kecamatan Mekar', 'kelurahan' => 'Kelurahan Mawar',
                'posyandu' => 'Posyandu Melati', 'tahun_pendataan' => 2024,
                'nama_ibu' => 'Ibu Ani', 'nama_ayah' => 'Budi', 'nama_bayi' => 'Rafi',
                'tgl_lahir' => '2022-03-14', 'keterangan' => 'Data contoh'
            ]
        ]);

        DB::table('format_2')->insert([
            [
                'kecamatan' => 'Kecamatan Mekar', 'kelurahan' => 'Kelurahan Mawar',
                'posyandu' => 'Posyandu Melati', 'tahun_pendataan' => 2024,
                'id_bayi' => 1, 'nama_bayi' => 'Rafi', 'jk' => 'L',
                'tgl_lhr' => '2022-03-14', 'bbl' => 12.4, 'ket' => '-'
            ]
        ]);

        DB::table('format_3')->insert([
            [
                'kecamatan' => 'Kecamatan Mekar', 'kelurahan' => 'Kelurahan Mawar',
                'posyandu' => 'Posyandu Melati', 'tahun_pendataan' => 2024,
                'nama_wuspus' => 'Ibu Ani', 'umur' => 28, 'nama_suami' => 'Budi',
                'jumlah_anak_hidup' => 1, 'pengukuran_lila' => 23.5, 'keterangan' => '-'
            ]
        ]);

        DB::table('format_4')->insert([
            [
                'kecamatan' => 'Kecamatan Mekar', 'kelurahan' => 'Kelurahan Mawar',
                'posyandu' => 'Posyandu Melati', 'tahun_pendataan' => 2024,
                'nama_ibu' => 'Ibu Ani', 'nama_bayi' => 'Rafi', 'umur' => 2,
                'tanggal_daftar' => '2022-03-15', 'umur_kehamilan' => 0,
                'lila' => 24.5, 'ket' => '-'
            ]
        ]);

        DB::table('format_5')->insert([
            [
                'kecamatan' => 'Kecamatan Mekar', 'kelurahan' => 'Kelurahan Mawar',
                'posyandu' => 'Posyandu Melati', 'tahun_pendataan' => 2024,
                'bln' => 'Januari', 'bayi_l' => 1, 'balita_l' => 1,
                'ibu_hamil' => 1, 'ibu_menyusui' => 0, 'ket' => '-'
            ]
        ]);

        // Berita
        DB::table('berita')->insert([
            ['judul' => 'Pelayanan Baru di Posyandu', 'ringkasan' => 'Penambahan layanan baru', 'isi' => 'Detail layanan baru posyandu ...', 'penulis' => 'Admin Posyandu']
        ]);

        // Operator Log
        DB::table('operator_log')->insert([
            ['id_operator' => 1, 'aksi' => 'Login', 'detail' => 'Login sukses']
        ]);

        // Goals
        DB::table('goals')->insert([
            ['nama_goal' => 'Menurunkan prevalensi stunting']
        ]);

        // Chat AI
        DB::table('ai_chat_history')->insert([
            ['id_operator' => 1, 'id_wuspus' => null, 'role' => 'user', 'pesan' => 'Bagaimana cara mendaftar bayi baru?', 'response' => 'Silakan buka menu Data Bayi -> Tambah Bayi'],
            ['id_operator' => 1, 'id_wuspus' => 1, 'role' => 'admin', 'pesan' => 'Saya ingin update data WUSPUS', 'response' => 'Silakan akses menu WUSPUS -> Edit'],
        ]);

        // Prediksi Stunting
        DB::table('ai_stunting_prediction')->insert([
            [
                'id_bayi' => 2, 'umur_bulan' => 18, 'berat_badan' => 8.50, 'tinggi_badan' => 72.0,
                'z_score' => null, 'status_gizi' => 'Berisiko Stunting', 'tingkat_risiko' => 68.50,
                'tanggal_prediksi' => '2025-10-13', 'rekomendasi' => 'Perlukan makanan tinggi protein + zat besi',
                'sumber_model' => 'rule_based_v1'
            ]
        ]);

        // operator role map
        DB::table('operator_role_map')->insert([
            [
                'id_operator' => 1,
                'lvl_id'      => 2,
            ],
            [
                'id_operator' => 2,
                'lvl_id'      => 3,
            ],
        ]);
    }
}
