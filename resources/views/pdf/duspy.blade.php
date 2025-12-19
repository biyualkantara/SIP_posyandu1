<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Data Posyandu</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; }
        h2 { margin: 0 0 10px 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #111; padding: 6px; vertical-align: top; }
        th { background: #f2f2f2; }
        .small { font-size: 9px; }
    </style>
</head>
<body>

<h2>Data Umum Posyandu</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Posyandu</th>
            <th>Strata</th>
            <th>Kecamatan</th>
            <th>Kelurahan</th>
            <th>Alamat</th>
            <th class="small">PJ Umum</th>
            <th class="small">PJ Operasional</th>
            <th class="small">Kader Aktif</th>
            <th class="small">Kader Tidak Aktif</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $it)
            <tr>
                <td>{{ $it->id_posyandu }}</td>
                <td>{{ $it->nama_posyandu }}</td>
                <td>{{ $it->strata_psy }}</td>
                <td>{{ optional(optional($it->kelurahan)->kecamatan)->nama_kec }}</td>
                <td>{{ optional($it->kelurahan)->nama_kel }}</td>
                <td>{{ $it->alamat_posyandu }}</td>
                <td class="small">{{ $it->pj_umum }}</td>
                <td class="small">{{ $it->pj_operasional }}</td>
                <td class="small">{{ $it->kader_aktif }}</td>
                <td class="small">{{ $it->kader_taktif }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>