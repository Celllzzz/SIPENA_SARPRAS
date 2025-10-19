<?php

namespace App\Http\Controllers;

use App\Models\PemeliharaanDarurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemeliharaanDaruratController extends Controller
{
    public function index(Request $request)
    {
        $query = PemeliharaanDarurat::query()->with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('sarana', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
        }

        $darurats = $query->latest()->paginate(10)->withQueryString();
        return view('admin.pemeliharaan.darurat.index', compact('darurats'));
    }

    public function create()
    {
        return view('admin.pemeliharaan.darurat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sarana' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'deskripsi_kerusakan' => 'required|string',
            'tanggal_pemeliharaan' => 'required|date',
            'tanggal_seharusnya' => 'nullable|date|after_or_equal:tanggal_pemeliharaan',
        ]);

        PemeliharaanDarurat::create($request->all() + ['user_id' => Auth::id()]);

        return redirect()->route('pemeliharaan-darurat.index')->with('success', 'Catatan pemeliharaan darurat berhasil ditambahkan.');
    }

    public function edit(PemeliharaanDarurat $pemeliharaanDarurat)
    {
        return view('admin.pemeliharaan.darurat.edit', ['pemeliharaan' => $pemeliharaanDarurat]);
    }

    public function update(Request $request, PemeliharaanDarurat $pemeliharaanDarurat)
    {
        $request->validate([
            'sarana' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'deskripsi_kerusakan' => 'required|string',
            'tanggal_pemeliharaan' => 'required|date',
            'tanggal_seharusnya' => 'nullable|date|after_or_equal:tanggal_pemeliharaan',
            'status' => 'required|string|in:Dalam Pengerjaan,Selesai',
            'biaya' => 'nullable|numeric|min:0',
            'catatan_perbaikan' => 'nullable|string',
        ]);

        $pemeliharaanDarurat->update($request->all() + ['user_id' => Auth::id()]);

        return redirect()->route('pemeliharaan-darurat.index')->with('success', 'Data pemeliharaan darurat berhasil diperbarui.');
    }

    public function destroy(PemeliharaanDarurat $pemeliharaanDarurat)
    {
        $pemeliharaanDarurat->delete();
        return redirect()->route('pemeliharaan-darurat.index')->with('success', 'Data pemeliharaan darurat berhasil dihapus.');
    }
}