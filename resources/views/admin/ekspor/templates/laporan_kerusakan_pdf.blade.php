<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kerusakan</title>
    <style> /* ... CSS untuk PDF ... */ </style>
</head>
<body>
    <h1>Rekap Laporan Kerusakan</h1>
    <p>Periode: {{ $startDate }} s/d {{ $endDate }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pelapor</th>
                <th>Sarana</th>
                <th>Lokasi</th>
                <th>Status</th>
                <th>Biaya</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->created_at->format('d-m-Y') }}</td>
                <td>{{ $item->user->name ?? '-' }}</td>
                <td>{{ $item->sarana }}</td>
                <td>{{ $item->lokasi }}</td>
                <td>{{ $item->status }}</td>
                <td>Rp {{ number_format($item->biaya_perbaikan, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>