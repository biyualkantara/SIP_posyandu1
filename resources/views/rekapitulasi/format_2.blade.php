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

        /* Column Width Adjustments for Format 2 (35 Columns) */
        .f2-no { width: 15px; }
        .f2-name { width: 70px; }
        .f2-date { width: 40px; }
        .f2-bb { width: 30px; }
        .f2-parent { width: 45px; }
        .f2-xs { width: 16px; }
        .f2-ket { width: 50px; }
    </style>
</head>
<body>

    <div class="page-break">
        <div class="title-container">
            <div class="title-main">FORMAT - 2 : REGISTER BAYI DALAM WILAYAH KERJA POSYANDU</div>
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
                @forelse($records ?? [] as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="text-align: left;">{{ $row->nama_bayi ?? '-' }}</td>
                    <td>{{ $row->tgl_lahir ? \Carbon\Carbon::parse($row->tgl_lahir)->format('d-m-Y') : '-' }}</td>
                    <td>{{ $row->bb_lahir ?? '-' }}</td>
                    <td>{{ $row->nama_ayah ?? '-' }}</td>
                    <td>{{ $row->nama_ibu ?? '-' }}</td>
                    <td>{{ $row->dasa_wisma ?? '-' }}</td>
                    
                    {{-- Hasil Penimbangan per Bulan --}}
                    <td>{{ $row->bb_jan ?? '-' }}</td>
                    <td>{{ $row->bb_feb ?? '-' }}</td>
                    <td>{{ $row->bb_mar ?? '-' }}</td>
                    <td>{{ $row->bb_apr ?? '-' }}</td>
                    <td>{{ $row->bb_mei ?? '-' }}</td>
                    <td>{{ $row->bb_jun ?? '-' }}</td>
                    <td>{{ $row->bb_jul ?? '-' }}</td>
                    <td>{{ $row->bb_ags ?? '-' }}</td>
                    <td>{{ $row->bb_sep ?? '-' }}</td>
                    <td>{{ $row->bb_okt ?? '-' }}</td>
                    <td>{{ $row->bb_nov ?? '-' }}</td>
                    <td>{{ $row->bb_des ?? '-' }}</td>
                    
                    {{-- Vit A --}}
                    <td>{{ $row->vit_a1 ?? '-' }}</td>
                    <td>{{ $row->vit_a2 ?? '-' }}</td>
                    
                    {{-- BCG --}}
                    <td>{{ $row->bcg ?? '-' }}</td>
                    
                    {{-- DPT --}}
                    <td>{{ $row->dpt1 ?? '-' }}</td>
                    <td>{{ $row->dpt2 ?? '-' }}</td>
                    <td>{{ $row->dpt3 ?? '-' }}</td>
                    
                    {{-- POLIO --}}
                    <td>{{ $row->polio1 ?? '-' }}</td>
                    <td>{{ $row->polio2 ?? '-' }}</td>
                    <td>{{ $row->polio3 ?? '-' }}</td>
                    <td>{{ $row->polio4 ?? '-' }}</td>
                    
                    {{-- CAMPAK --}}
                    <td>{{ $row->campak ?? '-' }}</td>
                    
                    {{-- HEPATITIS --}}
                    <td>{{ $row->hep1 ?? '-' }}</td>
                    <td>{{ $row->hep2 ?? '-' }}</td>
                    <td>{{ $row->hep3 ?? '-' }}</td>
                    
                    {{-- Tanggal Meninggal & Keterangan --}}
                    <td>{{ $row->tgl_meninggal ? \Carbon\Carbon::parse($row->tgl_meninggal)->format('d-m-Y') : '-' }}</td>
                    <td style="text-align: left;">{{ $row->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="35" style="text-align: center; padding: 20px; font-style: italic;">
                        ⚠️ TIDAK ADA DATA UNTUK PERIODE INI
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div style="margin-top: 10px; font-size: 7px; text-align: right;">
            Dicetak: {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}
        </div>
    </div>
</body>
</html>