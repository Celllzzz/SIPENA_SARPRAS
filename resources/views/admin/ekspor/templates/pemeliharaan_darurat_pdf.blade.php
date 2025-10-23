<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pemeliharaan Darurat</title>
    <style>
        @page { size: landscape; }
        body { font-family: 'Helvetica', sans-serif; font-size: 9px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 22px; }
        .header p { margin: 0; font-size: 11px; color: #555; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 5px; text-align: left; }
        thead { background-color: #f2f2f2; }
        tbody tr:nth-child(even) { background-color: #f9f9f9; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Rekap Pemeliharaan Darurat</h1>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Sarana</th>
                <th>Lokasi</th>
                <th>Tgl Pemeliharaan</th>
                <th>Jadwal Seharusnya</th>
                <th>Status</th>
                <th>Deskripsi</th>
                <th>Biaya</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->sarana }}</td>
                <td>{{ $item->lokasi }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_pemeliharaan)->format('d-m-Y') }}</td>
                <td>{{ $item->tanggal_seharusnya ? \Carbon\Carbon::parse($item->tanggal_seharusnya)->format('d-m-Y') : '-' }}</td>
                <td>{{ $item->status }}</td>
                <td>{{ $item->deskripsi_kerusakan }}</td>
                <td>Rp {{ number_format($item->biaya, 0, ',', '.') }}</td>
                <td>{{ $item->catatan_perbaikan }}</td>
            </tr>
            @empty
            <tr><td colspan="9" class="text-center">Tidak ada data untuk periode ini.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>