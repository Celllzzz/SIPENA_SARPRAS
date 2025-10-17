<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class NotifikasiController extends Controller
{
    /**
     * Menampilkan halaman notifikasi.
     */
    public function index(): View
    {
        // Path diubah, tanpa subfolder 'notifikasi'
        return view('admin.notifikasi');
    }
}