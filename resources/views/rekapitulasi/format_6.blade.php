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
            font-size: 9px;
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
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .meta-info {
            font-size: 10px;
            line-height: 1.4;
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
            white-space: nowrap;
        }

        table.main-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .th-vertical {
            height: 90px;
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

        .col-no { width: 15px; }
        .col-bulan { width: 50px; text-align: left !important; padding-left: 3px !important; }
        .col-std { width: 22px; }
        .col-kb { width: 18px; }
        .col-balita { width: 18px; }

        .row-number th {
            font-size: 7px;
            background-color: #ddd;
            height: 12px;
            padding: 0;
        }

        .data-row td {
            height: 18px;
        }
        
        .text-left { text-align: left !important; padding-left: 5px !important; }
        
        .small-header {
            font-size: 7px;
            white-space: normal;
            line-height: 1.1;
        }

    </style>
</head>
<body>

    <div class="header-section">
        <div class="header-title">DATA KEGIATAN POSYANDU</div>
        <div class="header-title" style="font-size: 10px; font-weight: normal;">FORMAT 6</div>
        <div class="meta-info">
            NAMA POSYANDU : {{ $posyandu ?? 'SEMUA POSYANDU' }}<br>
            KELURAHAN : {{ $kelurahan ?? 'SEMUA KELURAHAN' }}<br>
            KECAMATAN : {{ $kecamatan ?? 'SEMUA KECAMATAN' }}<br>
            TAHUN : {{ $tahun ?: date('Y') }}
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

                <th rowspan="2" class="col-kb">L</th> 
                <th rowspan="2" class="col-kb">P</th> 
            </tr>

            <tr>
                <th class="col-balita">L</th><th class="col-balita">P</th>
                <th class="col-balita">L</th><th class="col-balita">P</th>
                <th class="col-balita">L</th><th class="col-balita">P</th>
                <th class="col-balita">L</th><th class="col-balita">P</th>
                <th class="col-balita">L</th><th class="col-balita">P</th>
                <th class="col-balita">L</th><th class="col-balita">P</th>
            </tr>

            <tr class="row-number">
                <th>1</th> <th>2</th> <th>3</th><th>4</th><th>5</th><th>6</th> 
                <th>7</th><th>8</th><th>9</th><th>10</th><th>11</th><th>12</th><th>13</th><th>14</th> 
                <th>15</th><th>16</th> <th>17</th><th>18</th> <th>19</th><th>20</th> <th>21</th><th>22</th> 
                <th>23</th><th>24</th> <th>25</th><th>26</th> <th>27</th><th>28</th> 
            </tr>
        </thead>
        <tbody>
            @forelse($records ?? [] as $row)
            <tr class="data-row">
                <td>{{ $row->no }}</td>
                <td class="text-left">{{ $row->bulan }}</td>
                <td>{{ $row->jml_ibu_hamil }}</td>
                <td>{{ $row->diperiksa }}</td>
                <td>{{ $row->fe_tab }}</td>
                <td>{{ $row->jml_ibu_menyusui }}</td>
                
                {{-- KB --}}
                <td>{{ $row->kb_kondom }}</td>
                <td>{{ $row->kb_pil }}</td>
                <td>{{ $row->kb_implant }}</td>
                <td>{{ $row->kb_mop }}</td>
                <td>{{ $row->kb_mow }}</td>
                <td>{{ $row->kb_iud }}</td>
                <td>{{ $row->kb_suntik }}</td>
                <td>{{ $row->kb_lain }}</td>
                
                {{-- Balita S --}}
                <td>{{ $row->balita_l }}</td>
                <td>{{ $row->balita_p }}</td>
                
                {{-- KMS --}}
                <td>{{ $row->kms_l }}</td>
                <td>{{ $row->kms_p }}</td>
                
                {{-- Ditimbang --}}
                <td>{{ $row->ditimbang_l }}</td>
                <td>{{ $row->ditimbang_p }}</td>
                
                {{-- Naik --}}
                <td>{{ $row->naik_l }}</td>
                <td>{{ $row->naik_p }}</td>
                
                {{-- Vit A --}}
                <td>{{ $row->vit_a_l }}</td>
                <td>{{ $row->vit_a_p }}</td>
                
                {{-- PMT --}}
                <td>{{ $row->pmt_l }}</td>
                <td>{{ $row->pmt_p }}</td>
                
                {{-- TT --}}
                <td>{{ $row->tt_l }}</td>
                <td>{{ $row->tt_p }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="28" style="text-align: center; padding: 20px;">
                    ⚠️ TIDAK ADA DATA KEGIATAN UNTUK PERIODE INI
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div style="margin-top: 10px; font-size: 7px; text-align: right;">
        Dicetak: {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}
    </div>
</body>
</html>