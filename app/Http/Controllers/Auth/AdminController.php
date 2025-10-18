<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'admin');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('per_page', 10);
        $admins = $query->latest()->paginate($perPage)->withQueryString();

        return view('auth.admin.daftarAdmin', compact('admins'));
    }

    public function create()
    {
        return view('auth.admin.createAdmin');
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('admin.index')->with('success', 'Admin baru berhasil ditambahkan.');
    }

    public function edit(User $admin)
    {
        return view('auth.admin.editAdmin', compact('admin'));
    }

    public function update(Request $request, User $admin)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class.',email,'.$admin->id],
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->save();

        return redirect()->route('admin.index')->with('success', 'Data admin berhasil diperbarui.');
    }
    
    public function destroy(User $admin)
    {
        if ($admin->id === auth()->id()) {
            return redirect()->route('admin.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $admin->delete();

        return redirect()->route('admin.index')->with('success', 'Akun admin berhasil dihapus.');
    }

    /**
     *  Menampilkan form untuk mengubah password admin.
     */
    public function showChangePasswordForm(User $admin)
    {
        return view('auth.admin.changePassword', compact('admin'));
    }

    /**
     *  Mengupdate password admin di database.
     */
    public function updatePassword(Request $request, User $admin)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect()->route('admin.index')
            ->with('success', "Password untuk admin '{$admin->name}' telah berhasil diubah.");
    }
}