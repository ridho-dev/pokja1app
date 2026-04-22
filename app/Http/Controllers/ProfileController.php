<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Menampilkan form edit profil.
     */
    public function edit()
    {
        return view('pages.users.user-profile'); // Sesuaikan folder view Anda
    }

    /**
     * Memperbarui data profil pengguna.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        // 1. Validasi Input
        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ]);

        // 2. Update Nama dan Email
        $user->name = $request->name;

        // 3. Update Password (Hanya jika diisi)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil Anda berhasil diperbarui!');
    }
}
