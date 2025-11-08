<?php

namespace App\Http\Controllers;

use App\Models\Pelaporan;
use App\Models\LogAktivitas;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PelaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Menampilkan semua data pelaporan
    public function index(Request $request)
    {
        $query = Pelaporan::query();

        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        // Filter search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('sarana', 'like', "%{$search}%")
                ->orWhere('lokasi', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%")
                ->orWhere('catatan', 'like', "%{$search}%");
            });
        }

        // Ambil nilai per_page dari request (default 10)
        $perPage = $request->input('per_page', 10);

        $pelaporans = $query->latest()->paginate($perPage)->withQueryString();

        return view('user.dataPelaporan', compact('pelaporans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.formPelaporan');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Custom validator biar bisa ditangkap di Blade
        $validator = Validator::make($request->all(), [
            'sarana'    => 'required|string|max:255',
            'lokasi'    => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'bukti'     => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Jika validasi gagal → kirim error ke session
        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', 'Semua field wajib diisi dan file harus sesuai ketentuan!')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $buktiPath = null;
            if ($request->hasFile('bukti')) {
                $file = $request->file('bukti');

                $sarana = str_replace(' ', '', $request->sarana);
                $lokasi = str_replace(' ', '', $request->lokasi);

                $filename = 'bukti_' . $sarana . '_' . $lokasi . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('buktilaporan'), $filename);
                $buktiPath = 'buktilaporan/' . $filename;
            }

            $pelaporanBaru = Pelaporan::create([
                'user_id'   => Auth::id(),
                'sarana'    => $request->sarana,
                'lokasi'    => $request->lokasi,
                'deskripsi' => $request->deskripsi,
                'bukti'     => $buktiPath,
                'status'    => 'verifikasi',
            ]);

            $admins = \App\Models\User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notifikasi::create([
                    'user_id' => $admin->id,
                    'pelaporan_id' => $pelaporanBaru->id,
                    'pesan' => 'Laporan baru untuk ' . $pelaporanBaru->sarana . ' dari ' . Auth::user()->name,
                ]);
            }

            LogAktivitas::create([
                'pelaporan_id' => $pelaporanBaru->id,
                'user_id'      => Auth::id(),
                'aktivitas'    => 'Laporan dibuat oleh ' . Auth::user()->name,
            ]);

            return redirect()->route('dashboard')->with('success', 'Laporan berhasil dikirim.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelaporan $pelaporan)
    {
        // Pastikan user hanya bisa melihat laporannya sendiri
        if (Auth::user()->role !== 'admin' && $pelaporan->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }
        
        // Eager load relasi
        $pelaporan->load(['user', 'logs.user']);

        return view('user.showPelaporan', compact('pelaporan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pelaporan $pelaporan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pelaporan $pelaporan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelaporan $pelaporan)
    {
        //
    }
}
