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
use PhpOffice\PhpSpreadsheet\Style\Alignment; // <-- DITAMBAHKAN
use PhpOffice\PhpSpreadsheet\Style\Font; // <-- DITAMBAHKAN

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

        // Format Tanggal (Zona Waktu Makassar/WITA UTC+8)
        $tglPemeliharaanFormatted = Carbon::parse($row->tanggal_pemeliharaan)->setTimezone('Asia/Makassar')->format('d-m-Y');
        $tglSeharusnyaFormatted = $row->tanggal_seharusnya ? Carbon::parse($row->tanggal_seharusnya)->setTimezone('Asia/Makassar')->format('d-m-Y') : '-';

        // Format Biaya (50000 -> 50.000)
        $biayaFormatted = is_numeric($row->biaya) ? number_format($row->biaya, 0, ',', '.') : '-';

        return [
            $this->rowNumber,
            $row->sarana,
            $row->lokasi,
            $tglPemeliharaanFormatted, // <-- DIPERBARUI
            $tglSeharusnyaFormatted, // <-- DIPERBARUI
            $row->status,
            $row->deskripsi_kerusakan,
            $biayaFormatted, // <-- DIPERBARUI
            $row->catatan_perbaikan,
        ];
    }

    public function columnWidths(): array
    {
        return [ 'A' => 5, 'G' => 50, 'I' => 50 ];
    }

    public function styles(Worksheet $sheet)
    {
        // Styling header tabel dipindah ke registerEvents
        return [];
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

                // Styling Judul Utama
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18); // <-- DIPERBESAR
                $sheet->getStyle('A1:A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Styling Header Tabel (Baris ke-4) <-- DITAMBAHKAN
                $headerRange = 'A4:I4';
                $sheet->getStyle($headerRange)->getFont()->setBold(true)->setSize(12);
                $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getRowDimension('4')->setRowHeight(25); // Opsional

                // Tambahkan Border (dimulai dari A4)
                $highestRow = $sheet->getHighestRow();
                $cellRange = 'A4:I' . $highestRow;
                $sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                
                // Text Wrapping (dimulai dari baris 5)
                $sheet->getStyle('G5:G'.$highestRow)->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_TOP);
                $sheet->getStyle('I5:I'.$highestRow)->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_TOP);
                
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