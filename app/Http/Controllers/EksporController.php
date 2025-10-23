<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelaporan;
use App\Models\PemeliharaanRutin;
use App\Models\PemeliharaanDarurat;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Exports\LaporanKerusakanExport;
use App\Exports\PemeliharaanRutinExport;
use App\Exports\PemeliharaanDaruratExport;

class EksporController extends Controller
{
    public function index()
    {
        return view('admin.ekspor.index');
    }

    public function export(Request $request)
    {
        $request->validate([
            'report_type' => 'required|string|in:laporan_kerusakan,pemeliharaan_rutin,pemeliharaan_darurat',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'format' => 'required|string|in:pdf,excel',
        ]);

        $reportType = $request->report_type;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $format = $request->format;

        $startDateFormatted = Carbon::parse($startDate)->format('d-m-Y'); // Format d-m-y
        $endDateFormatted = Carbon::parse($endDate)->format('d-m-Y');

        $filename = "{$reportType}_{$startDateFormatted}_sampai_{$endDateFormatted}";

        $data = null;
        $exportClass = null;
        $viewName = 'admin.ekspor.templates.' . $reportType . '_pdf';

        if ($reportType === 'laporan_kerusakan') {
            $data = Pelaporan::whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])->with('user')->latest()->get();
            // Kirim tanggal ke class export
            $exportClass = new LaporanKerusakanExport($data, $startDate, $endDate);
        } elseif ($reportType === 'pemeliharaan_rutin') {
            $data = PemeliharaanRutin::whereBetween('tanggal_berikutnya', [$startDate, $endDate])->with('catatans.user')->latest()->get();
            // Kirim tanggal ke class export
            $exportClass = new PemeliharaanRutinExport($data, $startDate, $endDate);
        } else { // pemeliharaan_darurat
            $data = PemeliharaanDarurat::whereBetween('tanggal_pemeliharaan', [$startDate, $endDate])->with('user')->latest()->get();
            // Kirim tanggal ke class export
            $exportClass = new PemeliharaanDaruratExport($data, $startDate, $endDate);
        }
        
        if ($data->isEmpty()) {
            return back()->with('error', 'Tidak ada data yang ditemukan untuk rentang tanggal yang dipilih.');
        }

        if ($format === 'pdf') {
            $pdf = Pdf::loadView($viewName, compact('data', 'startDate', 'endDate'))->setPaper('a4', 'landscape');
            return $pdf->download($filename . '.pdf');
        } else { // excel
            return Excel::download($exportClass, $filename . '.xlsx');
        }
    }
}