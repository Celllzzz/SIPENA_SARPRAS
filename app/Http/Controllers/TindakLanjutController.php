<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelaporan;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;
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
        $pelaporan = Pelaporan::with(['user', 'logs.user'])->findOrFail($id);
        
        //  Mengarahkan ke view form yang benar (tindakLanjut)
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
            'biaya' => 'nullable|string', 
        ]);

        $pelaporan = Pelaporan::findOrFail($id);

        // Simpan nilai lama untuk perbandingan log
        $statusLama = $pelaporan->status;
        $catatanLama = $pelaporan->catatan;
        $biayaLama = $pelaporan->biaya_perbaikan;

        $biayaClean = $request->biaya ? preg_replace('/[Rp. ]/', '', $request->biaya) : null;

        $pelaporan->status = $request->status;
        $pelaporan->catatan = $request->catatan;
        $pelaporan->biaya_perbaikan = $biayaClean;
        $pelaporan->save();

        $aktivitas = [];
        if ($statusLama !== $request->status) {
            $aktivitas[] = 'Status diubah dari "' . str_replace('_',' ',$statusLama) . '" menjadi "' . str_replace('_',' ',$request->status) . '"';
        }
        if ($catatanLama !== $request->catatan && !empty($request->catatan)) {
            $aktivitas[] = 'Catatan diperbarui';
        }
        if ($biayaLama != $biayaClean) { 
            $aktivitas[] = 'Biaya perbaikan diupdate menjadi Rp ' . number_format($biayaClean ?: 0, 0, ',', '.');
        }

        if (!empty($aktivitas)) {
            LogAktivitas::create([
                'pelaporan_id' => $pelaporan->id,
                'user_id'      => Auth::id(),
                'aktivitas'    => implode('. ', $aktivitas) . ' oleh ' . Auth::user()->name,
            ]);
        }

        return redirect()->route('tindak-lanjut.index')
                         ->with('success', 'Tindak lanjut berhasil diperbarui.');
    }
}