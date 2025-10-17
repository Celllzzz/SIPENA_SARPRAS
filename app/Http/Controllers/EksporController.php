<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class EksporController extends Controller
{
    /**
     * Menampilkan halaman ekspor PDF.
     */
    public function index(): View
    {
        // Path diubah, tanpa subfolder 'ekspor'
        return view('admin.ekspor');
    }
}