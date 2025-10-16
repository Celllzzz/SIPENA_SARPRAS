<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelaporan;

class TindakLanjutController extends Controller
{   
    public function index(Request $request)
    {
        $query = Pelaporan::query()->with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhere('sarana', 'like', "%{$search}%")
                ->orWhere('lokasi', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%")
                ->orWhere('catatan', 'like', "%{$search}%");
        }

        $pelaporans = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return view('admin.tindakLanjutTable', compact('pelaporans'))->render();
        }

        return view('admin.tindakLanjut', compact('pelaporans'));
    }


    public function edit($id)
    {
        $pelaporan = Pelaporan::findOrFail($id);
        return view('admin.tindakLanjutIndex', compact('pelaporan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:verifikasi,dalam_perbaikan,selesai',
            'catatan' => 'nullable|string',
            'biaya_perbaikan' => 'nullable|numeric|min:0',
        ]);

        $pelaporan = Pelaporan::findOrFail($id);
        $pelaporan->update([
            'status' => $request->status,
            'catatan' => $request->catatan,
            'biaya_perbaikan' => $request->biaya,
        ]);

        return redirect()->route('tindak-lanjut.index')
                        ->with('success', 'Tindak lanjut berhasil diperbarui.');

    }
}
