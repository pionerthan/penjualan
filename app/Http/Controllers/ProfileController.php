<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use Illuminate\Http\Request;
=======
use Illuminate\Http\Request;  // ← wajib ini
>>>>>>> 664d613eb671ee952505110855ffdac2a37313e3
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
<<<<<<< HEAD
    /**
     * Tampilkan halaman profil lengkap + histori pembelian
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil histori pembelian jika pelanggan ada
        $riwayat = $user->pelanggan ? $user->pelanggan->penjualans()->orderBy('TanggalPenjualan', 'desc')->get() : collect();

        return view('auth.profile', compact('user', 'riwayat'));
    }

    /**
     * Update profil user (nama, avatar, password)
     */
=======
    public function index()
    {
        return view('auth.profile', [
            'user' => Auth::user()
        ]);
    }

>>>>>>> 664d613eb671ee952505110855ffdac2a37313e3
    public function update(Request $request)
    {
        $user = Auth::user();

<<<<<<< HEAD
        // validasi input
=======
        // validasi
>>>>>>> 664d613eb671ee952505110855ffdac2a37313e3
        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password' => 'nullable|min:6'
        ]);

<<<<<<< HEAD
        $user->name = $request->name;

        // update avatar jika ada
=======
        // update nama
        $user->name = $request->name;

        // update avatar
>>>>>>> 664d613eb671ee952505110855ffdac2a37313e3
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $path = $file->store('avatars', 'public');
            $user->avatar = 'storage/' . $path;
        }

        // update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
