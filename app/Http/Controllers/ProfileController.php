<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil + histori pembelian
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil histori pembelian jika ada relasi pelanggan
        $riwayat = $user->pelanggan 
            ? $user->pelanggan->penjualans()->orderBy('TanggalPenjualan', 'desc')->get() 
            : collect();

        return view('auth.profile', compact('user', 'riwayat'));
    }

    /**
     * Update profil user (nama, avatar, password)
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi form
        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password' => 'nullable|min:6'
        ]);

        // Update nama
        $user->name = $request->name;

        // Update avatar jika ada
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $path = $file->store('avatars', 'public');
            $user->avatar = 'storage/' . $path;
        }

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
