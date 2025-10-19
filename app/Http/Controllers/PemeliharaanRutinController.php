<?php

namespace App\Http\Controllers;

use App\Models\PemeliharaanRutin;
use Illuminate\Http\Request;

class PemeliharaanRutinController extends Controller
{
    public function index(Request $request)
    {
        $query = PemeliharaanRutin::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('sarana', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
        }

        $jadwals = $query->latest()->paginate(10)->withQueryString();
        return view('admin.pemeliharaan.rutin.index', compact('jadwals'));
    }

    public function create()
    {
        return view('admin.pemeliharaan.rutin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sarana' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'frekuensi' => 'required|string',
            'tanggal_berikutnya' => 'required|date',
        ]);

        PemeliharaanRutin::create($request->all());

        return redirect()->route('pemeliharaan-rutin.index')->with('success', 'Jadwal pemeliharaan baru berhasil ditambahkan.');
    }

    public function edit(PemeliharaanRutin $pemeliharaanRutin)
    {   
        $pemeliharaanRutin->load('catatans.user');
        return view('admin.pemeliharaan.rutin.edit', ['jadwal' => $pemeliharaanRutin]);
    }

    public function update(Request $request, PemeliharaanRutin $pemeliharaanRutin)
    {
        $request->validate([
            'sarana' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'frekuensi' => 'required|string',
            'tanggal_berikutnya' => 'required|date',
            'status' => 'required|string|in:Terjadwal,Ditangguhkan',
        ]);

        $data = $request->except('catatan');
        $pemeliharaanRutin->update($request->all());

        return redirect()->route('pemeliharaan-rutin.index')->with('success', 'Jadwal pemeliharaan berhasil diperbarui.');
    }

    public function destroy(PemeliharaanRutin $pemeliharaanRutin)
    {
        $pemeliharaanRutin->delete();
        return redirect()->route('pemeliharaan-rutin.index')->with('success', 'Jadwal pemeliharaan berhasil dihapus.');
    }
}