<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Format 4 - Register Ibu Hamil</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9px;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact;
        }

        .header-section {
            text-align: center;
            margin-bottom: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .meta-info {
            margin-bottom: 10px;
            font-size: 10px;
            width: 100%;
        }
        
        .meta-info table {
            border: none;
            width: 60%;
            margin: 0 auto;
        }
        
        .meta-info td {
            border: none;
            padding: 2px;
            text-align: left;
        }

        table.main-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        table.main-table th, 
        table.main-table td {
            border: 1px solid #000;
            padding: 2px;
            text-align: center;
            vertical-align: middle;
            font-size: 8px;
            overflow: hidden;
        }

        table.main-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .th-vertical {
            height: 100px;
            vertical-align: bottom;
            padding-bottom: 5px;
            position: relative;
        }

        .vertical-text {
            transform: rotate(-90deg);
            transform-origin: center;
            display: inline-block;
            white-space: nowrap;
            width: 20px;
            margin-bottom: 15px; 
        }

        .col-no { width: 15px; }
        .col-nama { width: 90px; text-align: left !important; padding-left: 4px !important; }
        .col-umur { width: 20px; }
        .col-dasa { width: 25px; }
        .col-date { width: 30px; }
        .col-check { width: 15px; }
        .col-bulan { width: 12px; }

        .row-number th {
            font-size: 7px;
            background-color: #ddd;
            height: 12px;
            vertical-align: middle;
            padding: 0;
        }

        .data-row td {
            height: 18px;
        }
    </style>
</head>
<body>

    <div class="header-section">
        FORMAT - 4 : REGISTER IBU HAMIL DALAM WILAYAH KERJA POSYANDU<br>
        JANUARI S.D DESEMBER {{ $tahun ?: date('Y') }}
    </div>

    <div class="meta-info">
        <table>
            <tr>
                <td width="100">POSYANDU</td>
                <td>: {{ $posyandu ?? 'SEMUA POSYANDU' }}</td>
            </tr>
            <tr>
                <td>DESA/KEL</td>
                <td>: {{ $kelurahan ?? 'SEMUA KELURAHAN' }}</td>
            </tr>
            <tr>
                <td>KECAMATAN</td>
                <td>: {{ $kecamatan ?? 'SEMUA KECAMATAN' }}</td>
            </tr>
            <tr>
                <td>KAB/KODYA</td>
                <td>: Cimahi</td>
            </tr>
        </table>
    </div>

    <table class="main-table">
        <thead>
            <tr>
                <th rowspan="3" class="col-no">NO</th>
                <th rowspan="3" class="col-nama">NAMA<br>IBU HAMIL</th>
                
                <th rowspan="3" class="col-umur th-vertical">
                    <div class="vertical-text">UMUR</div>
                </th>
                <th rowspan="3" class="col-dasa th-vertical">
                    <div class="vertical-text">KELOMPOK DASA WISMA</div>
                </th>
                
                <th colspan="2">PENDAF<br>TARAN</th>
                
                <th rowspan="3" class="col-umur th-vertical">
                    <div class="vertical-text">HAMIL KE</div>
                </th>
                
                <th colspan="3">PIL TAMBAH<br>DARAH</th>
                <th colspan="2">IMUNI<br>SASI TT</th>
                
                <th rowspan="3" class="col-check th-vertical">
                    <div class="vertical-text">KAPSUL YODIUM</div>
                </th>
                
                <th colspan="12">HASIL PENIMBANGAN</th>
                
                <th rowspan="3" class="col-check th-vertical">
                    <div class="vertical-text">RESIKO</div>
                </th>
                
                <th colspan="3">MELAHIRKAN</th>
                <th colspan="4">BAYI</th>
                
                <th rowspan="3" class="col-check">IBU<br>ME<br>NING<br>GAL</th>
            </tr>

            <tr>
                <th rowspan="2" class="col-date">TGL</th>
                <th rowspan="2" class="col-umur">UK<br>(bln)</th>
                
                <th rowspan="2" class="col-check">I</th>
                <th rowspan="2" class="col-check">II</th>
                <th rowspan="2" class="col-check">III</th>

                <th rowspan="2" class="col-check">I</th>
                <th rowspan="2" class="col-check">II</th>

                <th rowspan="2" class="col-bulan">J</th>
                <th rowspan="2" class="col-bulan">F</th>
                <th rowspan="2" class="col-bulan">M</th>
                <th rowspan="2" class="col-bulan">A</th>
                <th rowspan="2" class="col-bulan">M</th>
                <th rowspan="2" class="col-bulan">J</th>
                <th rowspan="2" class="col-bulan">J</th>
                <th rowspan="2" class="col-bulan">A</th>
                <th rowspan="2" class="col-bulan">S</th>
                <th rowspan="2" class="col-bulan">O</th>
                <th rowspan="2" class="col-bulan">N</th>
                <th rowspan="2" class="col-bulan">D</th>

                <th rowspan="2" class="col-date">TGL</th>
                <th colspan="2">DITOLONG<br>OLEH</th>

                <th colspan="3">HIDUP</th>
                <th rowspan="2" class="col-check">MA<br>TI</th>
            </tr>

            <tr>
                <th class="col-check">NA<br>KES</th>
                <th class="col-check">DU<br>KUN</th>
                
                <th class="col-check">&lt;2kg</th>
                <th class="col-check">2-<br>2,5</th>
                <th class="col-check">&gt;2,5</th>
             </tr>

             <tr class="row-number">
                 <th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th>
                 <th>11</th><th>12</th><th>13</th><th>14</th><th>15</th><th>16</th><th>17</th><th>18</th><th>19</th><th>20</th>
                 <th>21</th><th>22</th><th>23</th><th>24</th><th>25</th><th>26</th><th>27</th><th>28</th><th>29</th><th>30</th>
                 <th>31</th><th>32</th><th>33</th><th>34</th>
             </tr>
        </thead>
        <tbody>
            @forelse($records ?? [] as $index => $row)
            <tr class="data-row">
                <td>{{ $index + 1 }}</td>
                <td class="col-nama">{{ $row->nama_ibu }}</td>
                <td>{{ $row->umur }}</td>
                <td>{{ $row->dasa_wisma }}</td>
                <td>{{ $row->tgl_daftar ? \Carbon\Carbon::parse($row->tgl_daftar)->format('d/m') : '-' }}</td>
                <td>{{ $row->uk }}</td>
                <td>{{ $row->hamil_ke }}</td>
                <td>{{ $row->pil_i }}</td>
                <td>{{ $row->pil_ii }}</td>
                <td>{{ $row->pil_iii }}</td>
                <td>{{ $row->tt_i }}</td>
                <td>{{ $row->tt_ii }}</td>
                <td>{{ $row->kapsul_yodium }}</td>
                
                {{-- Hasil Penimbangan per Bulan --}}
                <td>{{ $row->bb_jan }}</td>
                <td>{{ $row->bb_feb }}</td>
                <td>{{ $row->bb_mar }}</td>
                <td>{{ $row->bb_apr }}</td>
                <td>{{ $row->bb_mei }}</td>
                <td>{{ $row->bb_jun }}</td>
                <td>{{ $row->bb_jul }}</td>
                <td>{{ $row->bb_ags }}</td>
                <td>{{ $row->bb_sep }}</td>
                <td>{{ $row->bb_okt }}</td>
                <td>{{ $row->bb_nov }}</td>
                <td>{{ $row->bb_des }}</td>
                
                <td>{{ $row->resiko }}</td>
                <td>{{ $row->tgl_melahirkan }}</td>
                <td>{{ $row->nakes }}</td>
                <td>{{ $row->dukun }}</td>
                <td>{{ $row->bayi_lt2kg }}</td>
                <td>{{ $row->bayi_2_25 }}</td>
                <td>{{ $row->bayi_gt25 }}</td>
                <td>{{ $row->bayi_mati }}</td>
                <td>{{ $row->ibu_meninggal }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="34" style="text-align: center; padding: 20px;">
                    ⚠️ TIDAK ADA DATA IBU HAMIL UNTUK PERIODE INI
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div style="margin-top: 10px; font-size: 7px; text-align: right;">
        Dicetak: {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }} | 
        Total Ibu Hamil: {{ count($records ?? []) }}
    </div>
</body>
</html>