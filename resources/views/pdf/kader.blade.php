<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Kader Posyandu</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #444; }
        th, td { padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
<h2>Daftar Kader Posyandu</h2>
<table>
    <thead>
    <tr>
        <th>Posyandu</th>
        <th>Nama</th>
        <th>Umur</th>
        <th>Jabatan</th>
        <th>No HP</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($data as $d)
        <tr>
            <td>{{ $d->duspy->nama_posyandu ?? '-' }}</td>
            <td>{{ $d->nama }}</td>
            <td>{{ $d->umur }}</td>
            <td>{{ $d->jabatan }}</td>
            <td>{{ $d->no_hp }}</td>
            <td>{{ $d->status }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
