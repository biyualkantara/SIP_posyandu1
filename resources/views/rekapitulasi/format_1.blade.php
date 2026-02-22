<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        .header-text { text-align: center; font-weight: bold; text-decoration: underline; margin-bottom: 20px; }
        .meta-data { margin-bottom: 10px; line-height: 1.5; }
        
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th, td { border: 1px solid black; padding: 5px; text-align: center; word-wrap: break-word; }
        
        /* Matching the column widths */
        .col-no { width: 30px; }
        .col-nama { width: 100px; }
        .col-tgl { width: 80px; }
        .col-ket { width: 120px; }

        .sub-header th { font-size: 10px; }
    </style>
</head>
<body>

    <div class="header-text">
        FORMAT - 1 : CATATAN IBU HAMIL, KELAHIRAN, KEMATIAN BAYI <br>
        DAN KEMATIAN IBU HAMIL, MELAHIRKAN / NIFAS {{ $tahun ? 'TAHUN ' . $tahun : '' }}
    </div>

    <div class="meta-data">
        <table>
            <tr style="border: none;">
                <td style="border: none; text-align: left; width: 100px;">POSYANDU</td>
                <td style="border: none; text-align: left;">: {{ $posyandu }}</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; text-align: left;">DESA/KEL.</td>
                <td style="border: none; text-align: left;">: {{ $kelurahan }}</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; text-align: left;">KECAMATAN</td>
                <td style="border: none; text-align: left;">: {{ $kecamatan }}</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; text-align: left;">KAB/KOTA</td>
                <td style="border: none; text-align: left;">: Cimahi</td>
            </tr>
        </table>
    </div>

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
            <tr style="background-color: #f2f2f2;">
                <th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th>
            </tr>
        </thead>
        {{-- <tbody>
            @foreach($records as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $row->nama_ibu }}</td>
                <td>{{ $row->nama_bapak }}</td>
                <td>{{ $row->nama_bayi }}</td>
                <td>{{ $row->tanggal_lahir }}</td>
                <td>{{ $row->tgl_meninggal_bayi ?? '-' }}</td>
                <td>{{ $row->tgl_meninggal_ibu ?? '-' }}</td>
                <td>{{ $row->keterangan }}</td>
            </tr>
            @endforeach
            </tbody> --}}
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Siti Aminah</td>
                    <td>Budi Santoso</td>
                    <td>Ahmad Rizki</td>
                    <td>2023-01-15</td>
                    <td>-</td>
                    <td>-</td>
                    <td>Bayi hidup</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Rina Marlina</td>
                    <td>Andi Pratama</td>
                    <td>Nabila Putri</td>
                    <td>2022-11-03</td>
                    <td>2022-12-10</td>
                    <td>-</td>
                    <td>Bayi wafat</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Dewi Lestari</td>
                    <td>Agus Saputra</td>
                    <td>Farhan Akbar</td>
                    <td>2021-06-20</td>
                    <td>-</td>
                    <td>2021-07-05</td>
                    <td>Ibu wafat pasca melahirkan</td>
                </tr>
            </tbody>

    </table>

</body>
</html>
