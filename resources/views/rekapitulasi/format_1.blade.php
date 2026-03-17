<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Format 1 - Catatan Ibu Hamil dan Bayi</title>
    <style>
        body { 
            font-family: sans-serif; 
            font-size: 11px; 
            margin: 20px;
        }
        .header-text { 
            text-align: center; 
            font-weight: bold; 
            text-decoration: underline; 
            margin-bottom: 20px; 
            font-size: 14px;
        }
        .meta-data { 
            margin-bottom: 20px; 
            line-height: 1.5;
            border: 1px solid #ddd;
            padding: 10px;
            background: #f9f9f9;
        }
        .info-filter {
            margin-bottom: 15px;
            padding: 8px;
            background: #e8f4f8;
            border-left: 4px solid #3498db;
            font-size: 10px;
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            table-layout: fixed; 
        }
        th, td { 
            border: 1px solid black; 
            padding: 5px; 
            text-align: center; 
            word-wrap: break-word; 
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        
        .col-no { width: 30px; }
        .col-nama { width: 100px; }
        .col-tgl { width: 80px; }
        .col-ket { width: 120px; }

        .sub-header th { 
            font-size: 10px; 
            background-color: #e6e6e6;
        }
        
        .data-kosong {
            text-align: center; 
            padding: 40px; 
            font-style: italic; 
            color: #999;
            background: #f5f5f5;
        }
        
        .footer {
            margin-top: 20px; 
            font-size: 9px; 
            text-align: right;
            color: #666;
            border-top: 1px dashed #ccc;
            padding-top: 10px;
        }
        
        .statistik {
            margin-top: 15px;
            padding: 8px;
            background: #f0f0f0;
            border-radius: 4px;
            font-size: 10px;
        }
    </style>
</head>
<body>

    <div class="header-text">
        FORMAT - 1 : CATATAN IBU HAMIL, KELAHIRAN, KEMATIAN BAYI <br>
        DAN KEMATIAN IBU HAMIL, MELAHIRKAN / NIFAS
    </div>

    <!-- Info Filter -->
    <div class="info-filter">
        <strong>FILTER LAPORAN:</strong><br>
        Kecamatan: {{ $kecamatan }} | 
        Kelurahan: {{ $kelurahan }} | 
        Posyandu: {{ $posyandu }} | 
        Tahun: {{ $tahun }}
    </div>

    <!-- Meta Data -->
    <div class="meta-data">
        <table style="border: none; width: 100%;">
            <tr style="border: none;">
                <td style="border: none; text-align: left; width: 120px;">POSYANDU</td>
                <td style="border: none; text-align: left;">: {{ $posyandu }}</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; text-align: left;">DESA/KELURAHAN</td>
                <td style="border: none; text-align: left;">: {{ $kelurahan }}</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; text-align: left;">KECAMATAN</td>
                <td style="border: none; text-align: left;">: {{ $kecamatan }}</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; text-align: left;">KAB/KOTA</td>
                <td style="border: none; text-align. left;">: CIMAHI</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; text-align: left;">TAHUN</td>
                <td style="border: none; text-align: left;">: {{ $tahun }}</td>
            </tr>
        </table>
    </div>

    <!-- Tabel Utama -->
    <table>
        <thead>
            <tr>
                <th rowspan="2" class="col-no">NO.</th>
                <th colspan="2">NAMA</th>
                <th rowspan="2">NAMA BAYI</th>
                <th rowspan="2" class="col-tgl">TANGGAL LAHIR</th>
                <th colspan="2">TANGGAL MENINGGAL</th>
                <th rowspan="2" class="col-ket">KETERANGAN</th>
            </tr>
            <tr class="sub-header">
                <th>IBU</th>
                <th>BAPAK</th>
                <th>BAYI</th>
                <th>IBU</th>
            </tr>
            <tr style="background-color: #d9d9d9;">
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
                <th>8</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $row->nama_ibu }}</td>
                <td>{{ $row->nama_bapak }}</td>
                <td>{{ $row->nama_bayi }}</td>
                <td>{{ $row->tgl_lahir ? \Carbon\Carbon::parse($row->tgl_lahir)->format('d-m-Y') : '-' }}</td>
                <td>{{ $row->tgl_meninggal_bayi ? \Carbon\Carbon::parse($row->tgl_meninggal_bayi)->format('d-m-Y') : '-' }}</td>
                <td>{{ $row->tgl_meninggal_ibu ? \Carbon\Carbon::parse($row->tgl_meninggal_ibu)->format('d-m-Y') : '-' }}</td>
                <td style="text-align: left;">{{ $row->keterangan }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="data-kosong">
                    ⚠️ TIDAK ADA DATA UNTUK FILTER INI<br>
                    <span style="font-size: 10px;">
                        Kecamatan: {{ $kecamatan }} | 
                        Kelurahan: {{ $kelurahan }} | 
                        Posyandu: {{ $posyandu }} | 
                        Tahun: {{ $tahun }}
                    </span>
                    @if(is_numeric($tahun) && $tahun > $tahunSekarang)
                        <br><br>
                        <strong style="color: #e74c3c;">
                            ⚠️ PERHATIAN: Tahun {{ $tahun }} belum berjalan atau data belum dimasukkan!
                            <br>Maksimal tahun yang tersedia: {{ $tahunSekarang }}
                        </strong>
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr style="font-weight: bold; background-color: #f2f2f2;">
                <td colspan="8" style="text-align: right; padding: 8px;">
                    TOTAL DATA: {{ $total }} BAYI
                </td>
            </tr>
        </tfoot>
    </table>

    <!-- Statistik -->
    <div class="statistik">
        <strong>STATISTIK:</strong><br>
        - Total Bayi: {{ $total }}<br>
        - Bayi Meninggal: {{ collect($records)->filter(function($item) { return $item->tgl_meninggal_bayi; })->count() }}<br>
        - Ibu Meninggal: {{ collect($records)->filter(function($item) { return $item->tgl_meninggal_ibu; })->count() }}<br>
        - Tanggal Cetak: {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}<br>
        - Dicetak Oleh: Sistem
    </div>

    <div class="footer">
        Dokumen ini dicetak secara otomatis dari Sistem Informasi Posyandu<br>
        *Data berdasarkan filter yang dipilih
    </div>

</body>
</html>