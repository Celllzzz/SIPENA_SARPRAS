<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;

class AdminController extends Controller
{
    /**
     * Form tambah admin
     */
    public function create()
    {
        return view('auth.admin.createAdmin'); // bikin blade untuk tambah admin
    }

    /**
     * Simpan admin baru
     */
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $admin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', // 👈 default role admin
        ]);

        event(new Registered($admin));

        return redirect()->route('admin.index')
                         ->with('success', 'Admin berhasil ditambahkan.');
    }

    /**
     * Daftar semua admin
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'admin');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $admins = $query->latest()->paginate(10)->withQueryString();

        return view('auth.admin.daftarAdmin', compact('admins'));
    }
}
