<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use Carbon\Carbon;

class VoucherController extends Controller
{
    public function cek(Request $request)
{
    $now = \Carbon\Carbon::now();

    $voucher = \App\Models\Voucher::where('kode_voucher', $request->kode)->first();

    if (!$voucher) {
        return response()->json([
            'success' => false,
            'message' => 'Kode voucher tidak ditemukan!'
        ]);
    }

    if (Carbon::parse($voucher->mulai_berlaku)->gt($now) || 
        Carbon::parse($voucher->kadaluarsa)->lt($now)) {
        return response()->json([
            'success' => false,
            'message' => 'Voucher sudah kadaluarsa atau belum berlaku!'
        ]);
    }

    if ($voucher->digunakan >= $voucher->limit_penggunaan) {
        return response()->json([
            'success' => false,
            'message' => 'Voucher sudah mencapai batas penggunaan!'
        ]);
    }

    $diskon = ($request->total * $voucher->diskon_persen) / 100;
    $totalSetelahDiskon = $request->total - $diskon;

    $voucher->increment('digunakan');

    return response()->json([
        'success' => true,
        'diskon' => $diskon,
        'total_setelah_diskon' => $totalSetelahDiskon,
    ]);
}

}
