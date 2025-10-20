<?php

namespace App\Exports;

use App\Models\Pelaporan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanKerusakanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            "Tanggal Lapor",
            "Pelapor",
            "Sarana",
            "Lokasi",
            "Status",
            "Biaya Perbaikan (Rp)",
            "Catatan",
        ];
    }

    public function map($row): array
    {
        return [
            $row->created_at->format('d-m-Y'),
            $row->user->name ?? '-',
            $row->sarana,
            $row->lokasi,
            $row->status,
            $row->biaya_perbaikan,
            $row->catatan,
        ];
    }
}