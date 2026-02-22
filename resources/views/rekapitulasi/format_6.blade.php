<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Format 6 - Data Kegiatan Posyandu</title>
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
            margin-bottom: 10px;
        }

        .header-title {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .meta-info {
            font-size: 11px;
            line-height: 1.4;
        }

        table.main-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Kunci agar kolom rapi */
        }

        table.main-table th, 
        table.main-table td {
            border: 1px solid #000;
            padding: 2px;
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

        /* --- Styling Header Vertikal (Rotasi) --- */
        .th-vertical {
            height: 100px;
            vertical-align: bottom;
            position: relative;
            padding-bottom: 5px;
        }

        .vertical-text {
            transform: rotate(-90deg);
            transform-origin: center;
            display: inline-block;
            white-space: nowrap;
            width: 20px;
            margin-bottom: 15px; 
        }

        /* --- Pengaturan Lebar Kolom --- */
        .col-no { width: 20px; }
        .col-bulan { width: 70px; text-align: left !important; padding-left: 5px !important; }
        .col-std { width: 30px; } /* Kolom standar angka */
        .col-kb { width: 20px; } /* Kolom KB (Sempit) */
        .col-balita { width: 25px; } /* Kolom L/P Balita */

        /* Baris Nomor (1-28) */
        .row-number th {
            font-size: 8px;
            background-color: #ddd;
            height: 12px;
            padding: 0;
        }

        /* Styling Data */
        .data-row td {
            height: 20px;
        }
        
        .text-left { text-align: left !important; padding-left: 5px !important; }
        
        /* Font header kecil untuk judul panjang */
        .small-header {
            font-size: 8px;
            white-space: normal; /* Allow wrap */
            line-height: 1.1;
        }

    </style>
</head>
<body>

    <div class="header-section">
        <div class="header-title">DATA KEGIATAN POSYANDU</div> <div class="header-title" style="font-size: 10px; font-weight: normal;">FORMAT 6</div>
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
                <th rowspan="3" class="col-no">NO</th>
                <th rowspan="3" class="col-bulan">BULAN</th>
                <th rowspan="3" class="col-std th-vertical"><div class="vertical-text">JML IBU HAMIL</div></th>
                <th rowspan="3" class="col-std th-vertical"><div class="vertical-text">DIPERIKSA</div></th>
                <th rowspan="3" class="col-std th-vertical"><div class="vertical-text">FE TAB (TABLET BESI)</div></th>
                <th rowspan="3" class="col-std th-vertical"><div class="vertical-text">JML IBU MENYUSUI</div></th>
                
                <th colspan="8">JUMLAH AKSEPTOR KB</th>
                
                <th colspan="12">PENIMBANGAN BALITA</th>
                
                <th colspan="2" class="small-header">IMUNISASI TT<br>IBU HAMIL</th>
            </tr>

            <tr>
                <th rowspan="2" class="col-kb th-vertical"><div class="vertical-text">KONDOM</div></th>
                <th rowspan="2" class="col-kb th-vertical"><div class="vertical-text">PIL</div></th>
                <th rowspan="2" class="col-kb th-vertical"><div class="vertical-text">IMPLANT</div></th>
                <th rowspan="2" class="col-kb th-vertical"><div class="vertical-text">MOP</div></th>
                <th rowspan="2" class="col-kb th-vertical"><div class="vertical-text">MOW</div></th>
                <th rowspan="2" class="col-kb th-vertical"><div class="vertical-text">IUD</div></th>
                <th rowspan="2" class="col-kb th-vertical"><div class="vertical-text">SUNTIK</div></th>
                <th rowspan="2" class="col-kb th-vertical"><div class="vertical-text">LAIN-LAIN</div></th>

                <th colspan="2" class="small-header">JML BALITA<br>(S)</th>
                <th colspan="2" class="small-header">JML BALITA<br>YG MEMILIKI<br>KMS (K)</th>
                <th colspan="2" class="small-header">JML YG<br>DITIMBANG<br>(D)</th>
                <th colspan="2" class="small-header">JML YG NAIK<br>(N)</th>
                <th colspan="2" class="small-header">JML YG<br>MENDAPAT<br>VIT A</th>
                <th colspan="2" class="small-header">JML YG<br>MENDAPAT<br>PMT</th>

                <th rowspan="2" class="col-kb">L</th> <th rowspan="2" class="col-kb">P</th> </tr>

            <tr>
                <th class="col-balita">L</th><th class="col-balita">P</th>
                <th class="col-balita">L</th><th class="col-balita">P</th>
                <th class="col-balita">L</th><th class="col-balita">P</th>
                <th class="col-balita">L</th><th class="col-balita">P</th>
                <th class="col-balita">L</th><th class="col-balita">P</th>
                <th class="col-balita">L</th><th class="col-balita">P</th>
            </tr>

            <tr class="row-number">
                <th>1</th> <th>2</th> <th>3</th><th>4</th><th>5</th><th>6</th> <th>7</th><th>8</th><th>9</th><th>10</th><th>11</th><th>12</th><th>13</th><th>14</th> <th>15</th><th>16</th> <th>17</th><th>18</th> <th>19</th><th>20</th> <th>21</th><th>22</th> <th>23</th><th>24</th> <th>25</th><th>26</th> <th>27</th><th>28</th> </tr>
        </thead>
        <tbody>
            <tr class="data-row">
                <td>1</td>
                <td class="text-left">JANUARI</td>
                <td>2</td><td>0</td><td>0</td><td>16</td>
                <td>0</td><td>0</td><td>0</td><td>1</td><td>7</td><td>17</td><td>-</td><td>-</td>
                <td>20</td><td>23</td> <td>20</td><td>23</td> <td>20</td><td>23</td> <td>9</td><td>12</td>  <td>0</td><td>0</td>   <td>20</td><td>23</td> <td>0</td><td>0</td>   </tr>

            <tr class="data-row">
                <td>2</td>
                <td class="text-left">FEBRUARI</td>
                <td>5</td><td>0</td><td>5</td><td>16</td>
                <td>0</td><td>1</td><td>0</td><td>0</td><td>2</td><td>7</td><td>17</td><td>-</td>
                <td>20</td><td>24</td>
                <td>20</td><td>24</td>
                <td>20</td><td>24</td>
                <td>14</td><td>11</td>
                <td>17</td><td>22</td>
                <td>20</td><td>23</td>
                <td>0</td><td>0</td>
            </tr>

            <tr class="data-row">
                <td>3</td>
                <td class="text-left">MARET</td>
                <td>4</td><td>0</td><td>3</td><td>18</td>
                <td>0</td><td>1</td><td>0</td><td>0</td><td>2</td><td>8</td><td>17</td><td>-</td>
                <td>20</td><td>26</td>
                <td>20</td><td>26</td>
                <td>20</td><td>26</td>
                <td>8</td><td>14</td>
                <td>0</td><td>0</td>
                <td>20</td><td>26</td>
                <td>0</td><td>0</td>
            </tr>

            <tr class="data-row">
                <td>4</td>
                <td class="text-left">APRIL</td>
                <td>4</td><td>-</td><td>4</td><td>16</td>
                <td>0</td><td>1</td><td>0</td><td>0</td><td>2</td><td>8</td><td>17</td><td>-</td>
                <td>20</td><td>26</td><td>20</td><td>26</td><td>19</td><td>23</td><td>10</td><td>14</td><td>0</td><td>0</td><td>19</td><td>23</td><td>0</td><td>0</td>
            </tr>

            <tr class="data-row"><td>5</td><td class="text-left">MEI</td><td>2</td><td>-</td><td>2</td><td>18</td><td>0</td><td>1</td><td>0</td><td>0</td><td>2</td><td>8</td><td>19</td><td>-</td><td>19</td><td>28</td><td>19</td><td>28</td><td>19</td><td>28</td><td>11</td><td>13</td><td>0</td><td>0</td><td>19</td><td>28</td><td>0</td><td>0</td></tr>
            <tr class="data-row"><td>6</td><td class="text-left">JUNI</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr class="data-row"><td>7</td><td class="text-left">JULI</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr class="data-row"><td>8</td><td class="text-left">AGUSTUS</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr class="data-row"><td>9</td><td class="text-left">SEPTEMBER</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr class="data-row"><td>10</td><td class="text-left">OKTOBER</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr class="data-row"><td>11</td><td class="text-left">NOVEMBER</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr class="data-row"><td>12</td><td class="text-left">DESEMBER</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>

        </tbody>
    </table>

</body>
</html>