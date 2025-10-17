<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PemeliharaanController extends Controller
{
    /**
     * Menampilkan halaman pemeliharaan rutin.
     */
    public function rutin(): View
    {
        // Path view diubah ke folder admin
        return view('admin.rutin');
    }

    /**
     * Menampilkan halaman pemeliharaan darurat.
     */
    public function darurat(): View
    {
        // Path view diubah ke folder admin
        return view('admin.darurat');
    }
}