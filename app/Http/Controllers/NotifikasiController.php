<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasis = Notifikasi::where('user_id', Auth::id())->latest()->paginate(15);
        return view('notifikasi.index', compact('notifikasis'));
    }

    public function markAllAsRead()
    {
        Notifikasi::where('user_id', Auth::id())->where('is_read', false)->update(['is_read' => true]);
        return back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }
}