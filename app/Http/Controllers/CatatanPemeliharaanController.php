<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CatatanPemeliharaan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; 

class CatatanPemeliharaanController extends Controller
{
    public function store(Request $request)
    {
        // Menggunakan Validator secara manual untuk kontrol redirect
        $validator = Validator::make($request->all(), [
            'pemeliharaan_rutin_id' => 'required|exists:pemeliharaan_rutins,id',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            // Redirect kembali ke halaman edit yang spesifik dengan membawa error dan input lama
            return redirect()->route('pemeliharaan-rutin.edit', $request->pemeliharaan_rutin_id)
                ->withErrors($validator)
                ->withInput();
        }

        CatatanPemeliharaan::create([
            'pemeliharaan_rutin_id' => $request->pemeliharaan_rutin_id,
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'isi' => $request->isi,
        ]);

        // Redirect kembali ke halaman edit yang sama dengan pesan sukses
        return redirect()->route('pemeliharaan-rutin.edit', $request->pemeliharaan_rutin_id)
                         ->with('success', 'Catatan berhasil ditambahkan.');
    }
}