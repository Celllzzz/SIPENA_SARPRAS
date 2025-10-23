<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pemeliharaan Rutin</title>
    <style>
        @page { size: landscape; }
        body { font-family: 'Helvetica', sans-serif; font-size: 10px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; }
        .header p { margin: 0; font-size: 12px; color: #555; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        thead { background-color: #f2f2f2; }
        tbody tr:nth-child(even) { background-color: #f9f9f9; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Rekap Pemeliharaan Rutin</h1>
        <p>Periode Jadwal: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Sarana</th>
                <th>Lokasi</th>
                <th>Frekuensi</th>
                <th>Jadwal Berikutnya</th>
                <th>Status</th>
                <th>Catatan Terakhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $item)
            @php
                $catatanTerakhir = $item->catatans->first();
            @endphp
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->sarana }}</td>
                <td>{{ $item->lokasi }}</td>
                <td>{{ $item->frekuensi }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_berikutnya)->format('d-m-Y') }}</td>
                <td>{{ $item->status }}</td>
                <td>{{ $catatanTerakhir ? ($catatanTerakhir->isi . ' (oleh ' . $catatanTerakhir->user->name . ')') : '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center">Tidak ada data untuk periode ini.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>