<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Carbon\Carbon;

class PemeliharaanRutinExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents, WithColumnWidths, WithTitle
{
    protected $data;
    protected $startDate;
    protected $endDate;
    protected $rowNumber = 0;

    public function __construct($data, $startDate, $endDate)
    {
        $this->data = $data;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return $this->data;
    }

    public function title(): string
    {
        return 'Pemeliharaan Rutin';
    }

    public function headings(): array
    {
        return [ 'No', 'Nama Sarana', 'Lokasi', 'Frekuensi', 'Jadwal Berikutnya', 'Status', 'Catatan Terakhir' ];
    }

    public function map($row): array
    {
        $this->rowNumber++;
        $catatanTerakhir = $row->catatans->first();
        return [
            $this->rowNumber,
            $row->sarana,
            $row->lokasi,
            $row->frekuensi,
            \Carbon\Carbon::parse($row->tanggal_berikutnya)->format('d-m-Y'),
            $row->status,
            $catatanTerakhir ? ($catatanTerakhir->isi . ' (oleh ' . $catatanTerakhir->user->name . ')') : '-',
        ];
    }

    public function columnWidths(): array
    {
        return [ 'A' => 5, 'G' => 50 ];
    }

    public function styles(Worksheet $sheet)
    {
        return [ 4 => ['font' => ['bold' => true]] ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->insertNewRowBefore(1, 3);
                $sheet->mergeCells('A1:G1');
                $sheet->mergeCells('A2:G2');
                $sheet->setCellValue('A1', 'Rekap Jadwal Pemeliharaan Rutin');
                $sheet->setCellValue('A2', 'Periode Jadwal: ' . Carbon::parse($this->startDate)->format('d M Y') . ' s/d ' . Carbon::parse($this->endDate)->format('d M Y'));

                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A1:A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $highestRow = $sheet->getHighestRow();
                $cellRange = 'A4:G' . $highestRow;
                $sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                
                $sheet->getStyle('G5:G'.$highestRow)->getAlignment()->setWrapText(true)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
                
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $sheet->getColumnDimension('F')->setAutoSize(true);
            },
        ];
    }
}