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

class PemeliharaanDaruratExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents, WithColumnWidths, WithTitle
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
        return 'Pemeliharaan Darurat';
    }

    public function headings(): array
    {
        return [
            'No', 'Nama Sarana', 'Lokasi', 'Tgl Pemeliharaan', 'Jadwal Seharusnya',
            'Status', 'Deskripsi Kerusakan', 'Biaya Perbaikan (Rp)', 'Catatan Perbaikan'
        ];
    }

    public function map($row): array
    {
        $this->rowNumber++;
        return [
            $this->rowNumber,
            $row->sarana,
            $row->lokasi,
            \Carbon\Carbon::parse($row->tanggal_pemeliharaan)->format('d-m-Y'),
            $row->tanggal_seharusnya ? \Carbon\Carbon::parse($row->tanggal_seharusnya)->format('d-m-Y') : '-',
            $row->status,
            $row->deskripsi_kerusakan,
            $row->biaya,
            $row->catatan_perbaikan,
        ];
    }

    public function columnWidths(): array
    {
        return [ 'A' => 5, 'G' => 50, 'I' => 50 ];
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
                $sheet->mergeCells('A1:I1');
                $sheet->mergeCells('A2:I2');
                $sheet->setCellValue('A1', 'Rekap Catatan Pemeliharaan Darurat');
                $sheet->setCellValue('A2', 'Periode: ' . Carbon::parse($this->startDate)->format('d M Y') . ' s/d ' . Carbon::parse($this->endDate)->format('d M Y'));

                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A1:A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $highestRow = $sheet->getHighestRow();
                $cellRange = 'A4:I' . $highestRow;
                $sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                
                $sheet->getStyle('G5:G'.$highestRow)->getAlignment()->setWrapText(true)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
                $sheet->getStyle('I5:I'.$highestRow)->getAlignment()->setWrapText(true)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
                
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $sheet->getColumnDimension('F')->setAutoSize(true);
                $sheet->getColumnDimension('H')->setAutoSize(true);
            },
        ];
    }
}