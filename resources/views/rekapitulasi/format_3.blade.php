<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Posyandu - Format 3</title>
    <style>
        @page { 
            size: a4 landscape; 
            margin: 10mm; 
        }
        
        body { 
            font-family: Arial, sans-serif; 
            font-size: 8px; 
            margin: 0;
            padding: 0;
            color: #000;
        }

        .title-container {
            text-align: center;
            margin-bottom: 10px;
        }

        .title-main {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
        }

        .meta-info {
            margin-bottom: 10px;
        }
        .meta-info table {
            border: none;
            width: auto;
        }
        .meta-info td {
            border: none;
            padding: 1px 10px 1px 0;
            font-weight: bold;
            text-align: left;
            font-size: 9px;
        }

        table.main-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        table.main-table th, 
        table.main-table td {
            border: 1px solid #000;
            padding: 3px 2px;
            text-align: center;
            word-wrap: break-word;
        }

        .header-bg {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .f3-no { width: 20px; }
        .f3-name { width: 80px; }
        .f3-age { width: 25px; }
        .f3-husband { width: 60px; }
        .f3-ks { width: 25px; }
        .f3-dw { width: 40px; }
        .f3-number { width: 25px; }
        .f3-check { width: 18px; }
        .f3-med { width: 35px; }
        .f3-ket { width: 50px; }
    </style>
</head>
<body>
    <div>
        <div class="title-container">
            <div class="title-main">FORMAT - 3 : REGISTER WUS - PUS DALAM WILAYAH KERJA POSYANDU</div>
            <div style="font-weight: bold;">JANUARI S.D DESEMBER {{ $tahun ?: date('Y') }}</div>
        </div>

        <div class="meta-info">
            <table>
                <tr><td>POSYANDU</td><td>: {{ $posyandu ?? 'SEMUA POSYANDU' }}</td></tr>
                <tr><td>DESA/KEL.</td><td>: {{ $kelurahan ?? 'SEMUA KELURAHAN' }}</td></tr>
                <tr><td>KECAMATAN</td><td>: {{ $kecamatan ?? 'SEMUA KECAMATAN' }}</td></tr>
                <tr><td>KAB/KOTA</td><td>: Cimahi</td></tr>
            </table>
        </div>

        <table class="main-table">
            <thead>
                <tr class="header-bg">
                    <th rowspan="3" class="f3-no">NO</th>
                    <th rowspan="3" class="f3-name">NAMA WUS / PUS</th>
                    <th rowspan="3" class="f3-age">UMUR</th>
                    <th rowspan="3" class="f3-husband">NAMA SUAMI</th>
                    <th rowspan="3" class="f3-ks">TAHAPAN KS</th>
                    <th rowspan="3" class="f3-dw">KLP DASA WISMA</th>
                    <th colspan="2">JUMLAH ANAK</th>
                    <th rowspan="3" class="f3-med">PENGUKURAN LILA <23.5 cm</th>
                    <th colspan="4">PEMBERIAN</th>
                    <th colspan="3">KELUARGA BERENCANA</th>
                    <th rowspan="3" class="f3-ket">KET</th>
                </tr>
                <tr class="header-bg">
                    <th rowspan="2">YANG HIDUP</th>
                    <th rowspan="2">MENING GAL</th>
                    <th rowspan="2">KAPSUL YODIUM</th>
                    <th colspan="3">IMUNISASI TT</th>
                    <th rowspan="2">JENIS KONTRASEPSI YANG DI PAKAI</th>
                    <th colspan="2">PENGGANTIAN</th>
                </tr>
                <tr class="header-bg">
                    <th class="f3-check">I</th>
                    <th class="f3-check">II</th>
                    <th class="f3-check">LENGKAP</th>
                    <th class="f3-med">TGL/BULAN</th>
                    <th class="f3-med">JENIS KB BARU</th>
                </tr>
                <tr class="header-bg" style="font-size: 6px;">
                    <th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th>
                    <th>7</th><th>8</th><th>9</th><th>10</th>
                    <th>11</th><th>12</th><th>13</th><th>14</th><th>15</th><th>16</th><th>17</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records ?? [] as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="text-align: left;">{{ $row->nama_wuspus }}</td>
                    <td>{{ $row->umur }}</td>
                    <td style="text-align: left;">{{ $row->nama_suami }}</td>
                    <td>{{ $row->tahapan_ks }}</td>
                    <td style="text-align: left;">{{ $row->klmpk_dasawisma }}</td>
                    <td>{{ $row->jml_anak_hdp }}</td>
                    <td>{{ $row->jml_anak_meninggal }}</td>
                    <td>{{ $row->lila }}</td>
                    <td>{{ $row->kapsul_yodium }}</td>
                    <td>{{ $row->tt_i }}</td>
                    <td>{{ $row->tt_ii }}</td>
                    <td>{{ $row->tt_lengkap }}</td>
                    <td>{{ $row->jns_kontrasepsi }}</td>
                    <td>{{ $row->tgl_ganti ? \Carbon\Carbon::parse($row->tgl_ganti)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $row->kontrasepsi_baru }}</td>
                    <td>{{ $row->keterangan }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="17" style="text-align: center; padding: 20px;">
                        ⚠️ TIDAK ADA DATA WUS/PUS UNTUK PERIODE INI
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div style="margin-top: 10px; font-size: 7px; text-align: right;">
            Dicetak: {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }} | 
            Total WUS/PUS: {{ count($records ?? []) }}
        </div>
    </div>
</body>
</html>