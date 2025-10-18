<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelaporan;
use Illuminate\View\View; // Import View class

class TindakLanjutController extends Controller
{
    /**
     * Menampilkan daftar semua laporan untuk ditindaklanjuti.
     */
    public function index(Request $request): View
    {
        $query = Pelaporan::query()->with('user');

        // Filter search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('sarana', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('catatan', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $perPage = $request->input('per_page', 10);
        $pelaporans = $query->latest()->paginate($perPage)->withQueryString();

        // [PERBAIKAN] Mengarahkan ke view tabel yang benar (tindakLanjutIndex)
        return view('admin.tindakLanjutIndex', compact('pelaporans'));
    }

    /**
     * Menampilkan form untuk mengedit satu laporan spesifik.
     */
    public function edit($id): View
    {
        $pelaporan = Pelaporan::findOrFail($id);
        
        // [PERBAIKAN] Mengarahkan ke view form yang benar (tindakLanjut)
        return view('admin.tindakLanjut', compact('pelaporan'));
    }

    /**
     * Mengupdate data laporan di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:verifikasi,dalam_perbaikan,selesai',
            'catatan' => 'nullable|string',
            // [PERBAIKAN] Sesuaikan nama validasi dengan nama input di form
            'biaya' => 'nullable|numeric|min:0',
        ]);

        $pelaporan = Pelaporan::findOrFail($id);
        
        // Menggunakan method save() untuk konsistensi
        $pelaporan->status = $request->status;
        $pelaporan->catatan = $request->catatan;
        $pelaporan->biaya_perbaikan = $request->biaya; // Nama kolom DB tetap biaya_perbaikan
        $pelaporan->save();

        return redirect()->route('tindak-lanjut.index')
                         ->with('success', 'Tindak lanjut berhasil diperbarui.');
    }
}