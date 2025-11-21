<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\Pelanggan;

class AssignPelangganToUser
{
    public function handle(Login $event)
    {
        $user = $event->user;

        // Jika user sudah punya pelanggan, hentikan
        if ($user->pelanggan) {
            return;
        }

        // Coba cocokkan pelanggan lama berdasarkan nama user
        $pelanggan = Pelanggan::where('NamaPelanggan', $user->name)->first();

        if ($pelanggan) {

            // Hubungkan pelanggan lama ke user yang login
            $pelanggan->update([
                'user_id' => $user->id,
            ]);

        } else {

            // Jika tidak ada, buat pelanggan baru
            Pelanggan::create([
                'NamaPelanggan' => $user->name,
                'Alamat'        => '-',
                'NomorTelepon'  => '-',
                'user_id'       => $user->id,
            ]);
        }
    }
}
