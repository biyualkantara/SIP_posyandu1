<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Posyandu - Format 2</title>
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

    <div class="page-break">
        <div class="title-container">
            <div class="title-main">FORMAT - 2 : REGISTER BAYI DALAM WILAYAH KERJA POSYANDU</div>
            <div style="font-weight: bold;">JANUARI S.D DESEMBER {{ $tahun }}</div>
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
                    <th rowspan="2" class="f2-no">NO</th>
                    <th rowspan="2" class="f2-name">NAMA BAYI</th>
                    <th rowspan="2" class="f2-date">TANGGAL LAHIR</th>
                    <th rowspan="2" class="f2-bb">BERAT BADAN LAHIR</th>
                    <th colspan="2">NAMA</th>
                    <th rowspan="2" class="f2-xs">KLP DASA WISMA</th>
                    <th colspan="12">HASIL PENIMBANGAN</th>
                    <th colspan="2">VIT A</th>
                    <th rowspan="2" class="f2-xs">BCG</th>
                    <th colspan="11">PEMBERIAN IMUNISASI</th>
                    <th rowspan="2" class="f2-xs">TGL MENING GAL</th>
                    <th rowspan="2" class="f2-ket">KETERANGAN</th>
                </tr>
                <tr class="header-bg">
                    <th class="f2-parent">AYAH</th>
                    <th class="f2-parent">IBU</th>
                    <th class="f2-xs">J</th><th class="f2-xs">P</th><th class="f2-xs">M</th><th class="f2-xs">A</th><th class="f2-xs">M</th><th class="f2-xs">J</th>
                    <th class="f2-xs">J</th><th class="f2-xs">A</th><th class="f2-xs">S</th><th class="f2-xs">O</th><th class="f2-xs">N</th><th class="f2-xs">D</th>
                    <th class="f2-xs">I</th><th class="f2-xs">II</th>
                    <th colspan="3">DPT</th>
                    <th colspan="4">POLIO</th>
                    <th>CAM PAK</th>
                    <th colspan="3">HEP TITIS</th>
                </tr>
                <tr class="header-bg" style="font-size: 6px;">
                    <th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th>
                    <th>11</th><th>12</th><th>13</th><th>14</th><th>15</th><th>16</th><th>17</th><th>18</th><th>19</th><th>20</th>
                    <th>21</th><th>22</th><th>23</th><th>24</th><th>25</th><th>26</th><th>27</th><th>28</th><th>29</th><th>30</th>
                    <th>31</th><th>32</th><th>33</th><th>34</th><th>35</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td style="text-align: left;">M. ALIF AL FARISY</td>
                    <td>22-11-2022</td>
                    <td>2,7 / 48</td>
                    <td>YUSUF</td>
                    <td>RATNA</td>
                    <td>04</td>
                    <td>8,1</td><td>8,5</td><td>8,6</td><td>8,6</td><td>8,8</td><td>9,1</td><td>9,1</td><td>9,4</td><td>9,5</td><td>9,5</td><td>9,9</td><td>10,2</td>
                    <td>v</td><td></td>
                    <td>v</td>
                    <td>v</td><td>v</td><td>v</td>
                    <td>v</td><td>v</td><td>v</td><td>v</td>
                    <td>v</td>
                    <td>v</td><td>v</td><td>v</td>
                    <td></td>
                    <td>Sdh</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>