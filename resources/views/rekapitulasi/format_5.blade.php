<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Format 5 - Data Pengunjung & Petugas</title>
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
            font-size: 10px;
            line-height: 1.4;
            margin-left: 5px;
        }

        table.main-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        table.main-table th, 
        table.main-table td {
            border: 1px solid #000;
            padding: 2px 1px;
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

        .row-number th {
            font-size: 7px;
            background-color: #ddd;
            height: 12px;
            padding: 0;
        }

        .col-no { width: 15px; }
        .col-bulan { width: 50px; text-align: left !important; padding-left: 3px !important; }
        .col-data { width: 18px; }
        .col-ket { width: 60px; }

        .data-row td {
            height: 18px;
        }
        
        .text-left { text-align: left !important; padding-left: 5px !important; }
        .small-header { font-size: 7px; }

    </style>
</head>
<body>

    <div class="header-section">
        <div class="header-title">
            FORMAT 5. JUMLAH PENGUNJUNG/JUMLAH PETUGAS POSYANDU/JUMLAH BAYI LAHIR/MENINGGAL
        </div>
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
                <th>1</th> <th>2</th> 
                <th>3</th><th>4</th> <th>5</th><th>6</th> <th>7</th><th>8</th> <th>9</th><th>10</th> 
                <th>11</th> <th>12</th> <th>13</th> <th>14</th> <th>15</th><th>16</th>
                <th>17</th><th>18</th>
                <th>19</th><th>20</th>
                <th>21</th><th>22</th>
                <th>23</th><th>24</th>
                <th>25</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records ?? [] as $row)
            <tr class="data-row">
                <td>{{ $row->no }}</td>
                <td class="text-left">{{ $row->bulan }}</td>
                
                {{-- BALITA 0-12 BLN --}}
                <td>{{ $row->balita_0_12_l }}</td>
                <td>{{ $row->balita_0_12_p }}</td>
                <td>{{ $row->balita_0_12_l + $row->balita_0_12_p }}</td>
                <td>0</td>
                
                {{-- BALITA 1-5 TH --}}
                <td>{{ $row->balita_1_5_l }}</td>
                <td>{{ $row->balita_1_5_p }}</td>
                <td>{{ $row->balita_1_5_l + $row->balita_1_5_p }}</td>
                <td>0</td>
                
                <td>{{ $row->wus }}</td>
                <td>{{ $row->pus }}</td>
                <td>{{ $row->ibu_hamil }}</td>
                <td>{{ $row->ibu_menyusui }}</td>
                
                {{-- KADER --}}
                <td>{{ $row->kader_l }}</td>
                <td>{{ $row->kader_p }}</td>
                
                {{-- PLKB --}}
                <td>{{ $row->plkb_l }}</td>
                <td>{{ $row->plkb_p }}</td>
                
                {{-- MEDIS --}}
                <td>{{ $row->medis_l }}</td>
                <td>{{ $row->medis_p }}</td>
                
                {{-- BAYI LAHIR --}}
                <td>{{ $row->bayi_lahir_l }}</td>
                <td>{{ $row->bayi_lahir_p }}</td>
                
                {{-- BAYI MENINGGAL --}}
                <td>{{ $row->bayi_meninggal_l }}</td>
                <td>{{ $row->bayi_meninggal_p }}</td>
                
                {{-- KETERANGAN --}}
                <td class="text-left small-header">{{ $row->keterangan }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="25" style="text-align: center; padding: 20px;">
                    ⚠️ TIDAK ADA DATA UNTUK PERIODE INI
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