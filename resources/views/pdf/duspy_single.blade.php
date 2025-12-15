<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Posyandu</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { text-align: left; width: 25%; }
        td, th { padding: 6px; }
    </style>
</head>
<body>
<h2>Detail Posyandu: {{ $data->nama_posyandu }}</h2>
@if($data->foto)
    <img src="{{ public_path('uploads/posyandu/' . $data->foto) }}" style="height:120px; margin-bottom:12px;">
@endif
<table>
    <tr><th>Nama</th><td>{{ $data->nama_posyandu }}</td></tr>
    <tr><th>Strata</th><td>{{ $data->strata_psy }}</td></tr>
    <tr><th>Alamat</th><td>{{ $data->alamat_posyandu }}</td></tr>
    <tr><th>ID Kel</th><td>{{ $data->id_kel }}</td></tr>
    <tr><th>Kader Aktif</th><td>{{ $data->kader_aktif }}</td></tr>
    <tr><th>Kader Tidak Aktif</th><td>{{ $data->kader_taktif }}</td></tr>
</table>
</body>
</html>
