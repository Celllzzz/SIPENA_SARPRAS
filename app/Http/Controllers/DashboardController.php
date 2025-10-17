<?php

namespace App\Http\Controllers;

use App\Models\Pelaporan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard dengan data yang relevan.
     */
    public function index(): View
    {
        if (Auth::user()->role === 'admin') {
            // Data untuk Admin dengan status baru
            $totalLaporan = Pelaporan::count();
            $laporanVerifikasi = Pelaporan::where('status', 'verifikasi')->count();
            $laporanDalamPerbaikan = Pelaporan::where('status', 'dalam_perbaikan')->count();
            $laporanSelesai = Pelaporan::where('status', 'selesai')->count();
            $laporanTerbaru = Pelaporan::with('user')->latest()->take(5)->get();

            return view('dashboard', compact(
                'totalLaporan',
                'laporanVerifikasi',
                'laporanDalamPerbaikan',
                'laporanSelesai',
                'laporanTerbaru'
            ));
        } else {
            // Data untuk User biasa
            $laporanUser = Pelaporan::where('user_id', Auth::id())
                                    ->latest()
                                    ->take(5)
                                    ->get();
            return view('dashboard', ['laporanUser' => $laporanUser]);
        }
    }
}