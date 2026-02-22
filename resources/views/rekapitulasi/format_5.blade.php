<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Format 6 - Data Pengunjung & Petugas</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact;
        }

        .header-section {
            text-align: left;
            margin-bottom: 15px;
            font-weight: bold;
            position: relative;
        }

        .header-title {
            text-align: center;
            font-size: 12px;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .meta-info {
            font-size: 11px;
            line-height: 1.4;
            margin-left: 5px;
        }

        table.main-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Penting agar kolom rapi */
        }

        table.main-table th, 
        table.main-table td {
            border: 1px solid #000;
            padding: 3px 1px; /* Padding kiri-kanan kecil agar muat */
            text-align: center;
            vertical-align: middle;
            font-size: 9px;
            overflow: hidden;
            white-space: nowrap;
        }

        table.main-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        /* Styling baris Nomor (1-25) */
        .row-number th {
            font-size: 7px;
            background-color: #ddd;
            height: 12px;
            padding: 0;
        }

        /* Lebar Kolom */
        .col-no { width: 20px; }
        .col-bulan { width: 70px; text-align: left !important; padding-left: 5px !important; }
        .col-data { width: 25px; } /* Lebar standar untuk kolom angka */
        .col-ket { width: 80px; }

        /* Styling Data */
        .data-row td {
            height: 20px;
        }
        
        .data-input {
            width: 100%;
            border: none;
            text-align: center;
            font-family: inherit;
            font-size: inherit;
            background: transparent;
        }

        /* Alignment khusus */
        .text-left { text-align: left !important; padding-left: 5px !important; }
        
        /* Utility untuk tulisan kecil di header */
        .small-header { font-size: 8px; }

    </style>
</head>
<body>

    <div class="header-section">
        <div class="header-title">
            FORMAT 5. JUMLAH PENGUNJUNG/JUMLAH PETUGAS POSYANDU/JUMLAH BAYI LAHIR/MENINGGAL
        </div>
        <div class="meta-info">
            NAMA POSYANDU : {{ $posyandu }}<br>
            KELURAHAN : {{ $kelurahan }}<br>
            KECAMATAN : {{ $kecamatan }}<br>
            TAHUN : {{ $tahun }}
        </div>
    </div>

    <table class="main-table">
        <thead>
            <tr>
                <th rowspan="4" class="col-no">NO</th>
                <th rowspan="4" class="col-bulan">BULAN</th>
                <th colspan="12">JUMLAH PENGUNJUNG</th>
                <th colspan="6">JUMLAH PETUGAS YANG HADIR</th>
                <th colspan="4">JUMLAH BAYI</th>
                <th rowspan="4" class="col-ket">KETERANGAN</th>
            </tr>

            <tr>
                <th colspan="8">BALITA</th>
                <th rowspan="3" class="col-data">WUS</th>
                <th rowspan="3" class="col-data">PUS</th>
                <th colspan="2">IBU</th>
                
                <th colspan="2">KADER</th>
                <th colspan="2">PLKB</th>
                <th colspan="2">MEDIS DAN<br>PARAMEDIS</th>

                <th colspan="2">YANG LAHIR</th>
                <th colspan="2">MENINGGAL</th>
            </tr>

            <tr>
                <th colspan="4">0-12 BLN</th>
                <th colspan="4">1-5 TH</th>
                
                <th rowspan="2" class="col-data small-header">HAMIL</th>
                <th rowspan="2" class="col-data small-header">MENYUSUI</th>

                <th rowspan="2" class="col-data">L</th>
                <th rowspan="2" class="col-data">P</th>
                <th rowspan="2" class="col-data">L</th>
                <th rowspan="2" class="col-data">P</th>
                <th rowspan="2" class="col-data">L</th>
                <th rowspan="2" class="col-data">P</th>

                <th rowspan="2" class="col-data">L</th>
                <th rowspan="2" class="col-data">P</th>
                <th rowspan="2" class="col-data">L</th>
                <th rowspan="2" class="col-data">P</th>
            </tr>

            <tr>
                <th colspan="2" class="small-header">BARU</th>
                <th colspan="2" class="small-header">LAMA</th>
                <th colspan="2" class="small-header">BARU</th>
                <th colspan="2" class="small-header">LAMA</th>
            </tr>

            <tr class="row-number">
                <th>1</th> <th>2</th> <th>3</th><th>4</th> <th>5</th><th>6</th> <th>7</th><th>8</th> <th>9</th><th>10</th> <th>11</th> <th>12</th> <th>13</th> <th>14</th> <th>15</th><th>16</th>
                <th>17</th><th>18</th>
                <th>19</th><th>20</th>

                <th>21</th><th>22</th>
                <th>23</th><th>24</th>
                
                <th>25</th> </tr>
{{--             
            <tr class="row-number" style="background-color: white;">
                 <th style="border-bottom: 1px solid black; background: #fff;"></th>
                 <th style="border-bottom: 1px solid black; background: #fff;"></th>
                 <th>L</th><th>P</th>
                 <th>L</th><th>P</th>
                 <th>L</th><th>P</th>
                 <th>L</th><th>P</th>
                 <th colspan="15" style="background: #fff; text-align: left;"></th>
             </tr> --}}

        </thead>
        <tbody>
            <tr class="data-row">
                <td>1</td>
                <td class="text-left">JANUARI</td>
                <td>2</td><td>1</td>
                <td>3</td><td>3</td>
                <td>0</td><td>0</td>
                <td>15</td><td>19</td>
                <td>29</td><td>29</td>
                <td>4</td><td>16</td>
                <td>0</td><td>5</td>
                <td>0</td><td>0</td>
                <td>0</td><td>2</td>
                <td>1</td><td>0</td>
                <td>0</td><td>0</td>
                <td class="small-header text-left">Lahir (L)<br>13-01-2023</td>
            </tr>

            <tr class="data-row">
                <td>2</td>
                <td class="text-left">FEBRUARI</td>
                <td>0</td><td>1</td>
                <td>5</td><td>3</td>
                <td>0</td><td>1</td>
                <td>15</td><td>19</td>
                <td>29</td><td>29</td>
                <td>5</td><td>14</td>
                <td>0</td><td>5</td>
                <td>0</td><td>0</td>
                <td>0</td><td>2</td>
                <td>0</td><td>0</td>
                <td>0</td><td>0</td>
                <td class="small-header text-left">Lahir (P)<br>28-02-23</td>
            </tr>

             <tr class="data-row">
                <td>3</td>
                <td class="text-left">MARET</td>
                <td>0</td><td>2</td>
                <td>5</td><td>3</td>
                <td>0</td><td>2</td>
                <td>15</td><td>19</td>
                <td>29</td><td>29</td>
                <td>4</td><td>18</td>
                <td>0</td><td>4</td>
                <td>0</td><td>0</td>
                <td>0</td><td>1</td>
                <td>0</td><td>1</td>
                <td>0</td><td>0</td>
                <td></td>
            </tr>

            <tr class="data-row"><td>4</td><td class="text-left">APRIL</td><td>0</td><td>0</td><td>5</td><td>5</td><td>0</td><td>0</td><td>15</td><td>21</td><td>29</td><td>29</td><td>4</td><td>16</td><td>0</td><td>5</td><td>0</td><td>0</td><td>0</td><td>2</td><td>0</td><td>0</td><td>0</td><td>0</td><td></td></tr>
            <tr class="data-row"><td>5</td><td class="text-left">MEI</td><td>0</td><td>2</td><td>5</td><td>5</td><td>1</td><td>3</td><td>13</td><td>18</td><td>34</td><td>34</td><td>2</td><td>18</td><td>0</td><td>6</td><td>0</td><td>0</td><td>0</td><td>4</td><td>0</td><td>1</td><td>0</td><td>0</td><td class="text-left small-header">Lahir (P)</td></tr>
            <tr class="data-row"><td>6</td><td class="text-left">JUNI</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr class="data-row"><td>7</td><td class="text-left">JULI</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr class="data-row"><td>8</td><td class="text-left">AGUSTUS</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr class="data-row"><td>9</td><td class="text-left">SEPTEMBER</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr class="data-row"><td>10</td><td class="text-left">OKTOBER</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr class="data-row"><td>11</td><td class="text-left">NOVEMBER</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr class="data-row"><td>12</td><td class="text-left">DESEMBER</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>

        </tbody>
    </table>

</body>
</html>