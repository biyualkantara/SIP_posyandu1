<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Posyandu - Format 3</title>
    <style>
        /* PDF Page Setup */
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

        .page-break {
            page-break-after: always;
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

        /* Meta Data Table */
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

        /* Main Table Styling */
        table.main-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Crucial for keeping columns aligned */
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

        /* Column Width Adjustments for Format 2 (35 Columns) */
        .f2-no { width: 15px; }
        .f2-name { width: 70px; }
        .f2-date { width: 40px; }
        .f2-bb { width: 30px; }
        .f2-parent { width: 45px; }
        .f2-xs { width: 16px; } /* For months and immunizations */
        .f2-ket { width: 50px; }

        /* Column Width Adjustments for Format 4 (17 Columns) */
        .f4-no { width: 25px; }
        .f4-name { width: 90px; }
        .f4-age { width: 30px; }
        .f4-husband { width: 80px; }
        .f4-ks { width: 40px; }
        .f4-dw { width: 60px; }
        .f4-med { width: 40px; }
    </style>
</head>
<body>

    

    <div>
        <div class="title-container">
            <div class="title-main">FORMAT - 3 : REGISTER WUS - PUS DALAM WILAYAH KERJA POSYANDU</div>
            <div style="font-weight: bold;">JANUARI S.D DESEMBER {{ $tahun  }}</div>
        </div>

        <div class="meta-info">
            <table>
                <tr><td>POSYANDU</td><td>: {{ $posyandu }}</td></tr>
                <tr><td>DESA/KEL.</td><td>: {{ $kelurahan }}</td></tr>
                <tr><td>KECAMATAN</td><td>: {{ $kecamatan }}</td></tr>
                <tr><td>KAB/KOTA</td><td>: Cimahi</td></tr>
            </table>
        </div>

        <table class="main-table">
            <thead>
                <tr class="header-bg">
                    <th rowspan="3" class="f4-no">NO</th>
                    <th rowspan="3" class="f4-name">NAMA WUS / PUS</th>
                    <th rowspan="3" class="f4-age">UMUR</th>
                    <th rowspan="3" class="f4-husband">NAMA SUAMI</th>
                    <th rowspan="3" class="f4-ks">TAHAPAN KS</th>
                    <th rowspan="3" class="f4-dw">KLP DASA WISMA</th>
                    <th colspan="2">JUMLAH ANAK</th>
                    <th rowspan="3" class="f4-med">PENGUKURAN LILA <23.5 cm</th>
                    <th colspan="4">PEMBERIAN</th>
                    <th colspan="3">KELUARGA BERENCANA</th>
                    <th rowspan="3" class="f4-med">KET</th>
                </tr>
                <tr class="header-bg">
                    <th rowspan="2">YANG HIDUP</th>
                    <th rowspan="2">MENING GAL PADA UMUR</th>
                    <th rowspan="2">KAPSUL YODIUM (BLN)</th>
                    <th colspan="3">IMUNISASI TT</th>
                    <th rowspan="2">JENIS KONTRASEPSI YANG DI PAKAI</th>
                    <th colspan="2">PENGGANTIAN</th>
                </tr>
                <tr class="header-bg">
                    <th>I</th><th>II</th><th>LENGKAP</th>
                    <th>TGL/ BULAN</th>
                    <th>JENIS KONTRA SEPSI</th>
                </tr>
                <tr class="header-bg" style="font-size: 6px;">
                    <th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th>
                    <th>11</th><th>12</th><th>13</th><th>14</th><th>15</th><th>16</th><th>17</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td style="text-align: left;">YANI</td>
                    <td>49</td>
                    <td>BEDI. S</td>
                    <td>II</td>
                    <td>Binangkit</td>
                    <td>2</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td><td></td><td></td>
                    <td>IUD v</td>
                    <td></td><td></td>
                    <td>PUS</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td style="text-align: left;">FADILA</td>
                    <td>23</td>
                    <td>-</td>
                    <td></td>
                    <td>Binangkit</td>
                    <td>-</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td><td></td><td></td>
                    <td>-</td>
                    <td></td><td></td>
                    <td>WUS</td>
                </tr>
            </tbody>
        </table>
    </div>

</body>
</html>