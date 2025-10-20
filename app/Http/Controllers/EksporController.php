<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelaporan;
use App\Models\PemeliharaanRutin;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanKerusakanExport;
use App\Exports\PemeliharaanRutinExport;

class EksporController extends Controller
{
    /**
     * Menampilkan halaman utama untuk memilih jenis ekspor.
     */
    public function index()
    {
        return view('admin.ekspor.index');
    }

    /**
     * Menangani proses ekspor berdasarkan input dari form.
     */
    public function export(Request $request)
    {
        $request->validate([
            'report_type' => 'required|string|in:laporan_kerusakan,pemeliharaan_rutin',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'format' => 'required|string|in:pdf,excel',
        ]);

        $reportType = $request->report_type;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $format = $request->format;
        $filename = "{$reportType}_{$startDate}_sampai_{$endDate}";

        // Tentukan data yang akan diambil berdasarkan tipe laporan
        if ($reportType === 'laporan_kerusakan') {
            $data = Pelaporan::whereBetween('created_at', [$startDate, $endDate])->with('user')->latest()->get();
            $view = 'admin.ekspor.templates.laporan_kerusakan_pdf';
            $exportClass = new LaporanKerusakanExport($data);
        } else { // pemeliharaan_rutin
            $data = PemeliharaanRutin::whereBetween('tanggal_berikutnya', [$startDate, $endDate])->latest()->get();
            $view = 'admin.ekspor.templates.pemeliharaan_rutin_pdf';
            $exportClass = new PemeliharaanRutinExport($data);
        }
        
        // Cek apakah data kosong
        if ($data->isEmpty()) {
            return back()->with('error', 'Tidak ada data yang ditemukan untuk rentang tanggal yang dipilih.');
        }

        // Proses ekspor berdasarkan format yang dipilih
        if ($format === 'pdf') {
            $pdf = Pdf::loadView($view, compact('data', 'startDate', 'endDate'));
            return $pdf->download($filename . '.pdf');
        } else { // excel
            return Excel::download($exportClass, $filename . '.xlsx');
        }
    }
}