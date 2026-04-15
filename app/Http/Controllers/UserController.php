<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->latest()->get();
        $roles = Role::all();
        // Melempar data $users ke file blade index yang kita buat tadi
        return view('pages.users.user-management', compact('users', 'roles'));
    }

    /**
     * Menyimpan pengguna baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        // Memastikan email tidak boleh kembar (unique:users)
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'nip'      => 'nullable|string|max:18', // NIP biasanya maksimal 18 digit
            'password' => 'required|string|min:8',
            'role_id'     => 'required|exists:roles,id',
        ]);

        // 2. Simpan ke Database
        User::create([
            'name'     => $request->name,
            'nip'      => $request->nip,
            'username' => $request->username,
            'role_id'     => $request->role_id,
            // PENTING: Password harus di-hash (enkripsi) agar aman
            'password' => Hash::make($request->password), 
        ]);

        // 3. Kembalikan ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    /**
     * Menghapus pengguna dari database.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Proteksi Lapis 2 (Backend): Mencegah Admin menghapus dirinya sendiri via URL
        if (Auth::id() === $user->id) {
            return redirect()->back()->withErrors('Gagal! Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        // Eksekusi hapus
        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus dari sistem.');
    }
}
