<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Kader Posyandu</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { text-align: left; width: 25%; }
        td, th { padding: 6px; }
    </style>
</head>
<body>
<h2>Detail Kader: {{ $data->nama }}</h2>
@if($data->foto)
    <img src="{{ public_path('uploads/kader/' . $data->foto) }}" style="height:120px; margin-bottom:12px;">
@endif
<table>
    <tr><th>Posyandu</th><td>{{ $data->duspy->nama_posyandu ?? '-' }}</td></tr>
    <tr><th>Nama</th><td>{{ $data->nama }}</td></tr>
    <tr><th>Umur</th><td>{{ $data->umur }}</td></tr>
    <tr><th>Jabatan</th><td>{{ $data->jabatan }}</td></tr>
    <tr><th>No HP</th><td>{{ $data->no_hp }}</td></tr>
    <tr><th>Status</th><td>{{ $data->status }}</td></tr>
    <tr><th>Alamat</th><td>{{ $data->alamat }}</td></tr>
</table>
</body>
</html>
