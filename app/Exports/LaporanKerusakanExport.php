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
use Illuminate\Support\Str; // <-- DITAMBAHKAN
use PhpOffice\PhpSpreadsheet\Style\Alignment; // <-- DITAMBAHKAN
use PhpOffice\PhpSpreadsheet\Style\Font; // <-- DITAMBAHKAN

class LaporanKerusakanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents, WithColumnWidths, WithTitle
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
        return 'Laporan Kerusakan';
    }

    public function headings(): array
    {
        return [
            'No', 'Nama Pelapor', 'Nama Sarana', 'Lokasi', 'Deskripsi Kerusakan',
            'Status', 'Terakhir Update', 'Biaya Perbaikan (Rp)', 'Catatan Perbaikan'
        ];
    }

    public function map($row): array
    {
        $this->rowNumber++;

        // Format Status (underscore_jadi_spasi -> Title Case)
        $statusFormatted = Str::of($row->status)->replace('_', ' ')->title();

        // Format Biaya (50000 -> 50.000)
        $biayaFormatted = is_numeric($row->biaya_perbaikan) ? number_format($row->biaya_perbaikan, 0, ',', '.') : '-';

        // Format Tanggal (Zona Waktu Makassar/WITA UTC+8)
        $updatedAtFormatted = Carbon::parse($row->updated_at)->setTimezone('Asia/Makassar')->format('d-m-Y H:i');

        return [
            $this->rowNumber,
            $row->user->name ?? '-',
            $row->sarana,
            $row->lokasi,
            $row->deskripsi,
            $statusFormatted, 
            $updatedAtFormatted, 
            $biayaFormatted, 
            $row->catatan,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,    // No
            'E' => 50,   // Deskripsi Kerusakan
            'I' => 50,   // Catatan Perbaikan
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header berada di baris ke-4 setelah judul
        // Styling header tabel dipindah ke registerEvents agar lebih rapi
        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Tambah Judul dan Sub-judul
                $sheet->insertNewRowBefore(1, 3);
                $sheet->mergeCells('A1:I1');
                $sheet->mergeCells('A2:I2');
                $sheet->setCellValue('A1', 'Rekap Laporan Kerusakan');
                $sheet->setCellValue('A2', 'Periode: ' . Carbon::parse($this->startDate)->format('d M Y') . ' s/d ' . Carbon::parse($this->endDate)->format('d M Y'));

                // Styling Judul Utama
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18); // <-- DIPERBESAR
                $sheet->getStyle('A1:A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Styling Header Tabel (Baris ke-4) <-- DITAMBAHKAN
                $headerRange = 'A4:I4';
                $sheet->getStyle($headerRange)->getFont()->setBold(true)->setSize(12);
                $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getRowDimension('4')->setRowHeight(25); // Opsional: Atur tinggi baris header

                // Tambahkan Border ke seluruh tabel data (dimulai dari A4)
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $cellRange = 'A4:' . $highestColumn . $highestRow;
                $sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                
                // Text Wrapping (dimulai dari baris 5)
                $sheet->getStyle('E5:E'.$highestRow)->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_TOP);
                $sheet->getStyle('I5:I'.$highestRow)->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_TOP);
                
                // Auto-size untuk kolom lainnya
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('F')->setAutoSize(true);
                $sheet->getColumnDimension('G')->setAutoSize(true);
                $sheet->getColumnDimension('H')->setAutoSize(true);
            },
        ];
    }
}