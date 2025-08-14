<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;

class PelangganController extends Controller
{
    public function cari(Request $request)
    {
        $pelanggan = Pelanggan::where('NamaPelanggan', $request->nama)->first();

        if ($pelanggan) {
            return response()->json($pelanggan);
        } else {
            return response()->json(null);
        }
    }
}
