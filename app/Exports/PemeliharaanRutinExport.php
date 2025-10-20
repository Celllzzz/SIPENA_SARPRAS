<?php

namespace App\Exports;

use App\Models\PemeliharaanRutin;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PemeliharaanRutinExport implements FromCollection, WithHeadings, WithMapping
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
            "Sarana",
            "Lokasi",
            "Frekuensi",
            "Tanggal Berikutnya",
            "Status",
        ];
    }

    public function map($row): array
    {
        return [
            $row->sarana,
            $row->lokasi,
            $row->frekuensi,
            \Carbon\Carbon::parse($row->tanggal_berikutnya)->format('d-m-Y'),
            $row->status,
        ];
    }
}