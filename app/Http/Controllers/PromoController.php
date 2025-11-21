<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromoController extends Controller
{
    public function index(Request $request)
    {
        $now = now();

        $promotions = DB::table('promotions')
            ->where('is_active', 1)
            ->where('start_at', '<=', $now)
            ->where('end_at', '>=', $now)
            ->orderBy('start_at', 'asc')
            ->get();

        $recommended = DB::table('produk')
            ->where('status', 'active')
            ->orderBy('Stok','desc')
            ->limit(8)
            ->get();

        $vouchers = DB::table('vouchers')
            ->where('claimed', 0)
            ->get();

        return view('auth.promo-index', compact('promotions','recommended','vouchers'));
    }

    public function show($id)
    {
        $promo = DB::table('promotions')->where('id', $id)->first();

        if (!$promo) {
            abort(404, 'Promo tidak ditemukan');
        }

        $products = DB::table('promotion_products as pp')
            ->join('produk as p', 'pp.ProdukID', '=', 'p.ProdukID')
            ->where('pp.promotion_id', $id)
            ->select('p.*', 'pp.discount_price', 'pp.discount_percent')
            ->get();

        $vouchers = DB::table('vouchers')
            ->where('claimed', 0)
            ->get();

        return view('auth.promo-show', compact('promo', 'products', 'vouchers'));
    }

    public function claimVoucher(Request $request)
    {
        $request->validate([
            'voucher_id' => 'required|integer|exists:vouchers,id',
        ]);

        $voucherId = $request->voucher_id;

        try {
            $result = DB::transaction(function () use ($voucherId, $request) {

                $voucher = DB::table('vouchers')
                    ->where('id', $voucherId)
                    ->lockForUpdate()
                    ->first();

                if (!$voucher) {
                    return ['status'=>false, 'message'=>'Voucher tidak ditemukan'];
                }

                if ((int)$voucher->claimed === 1) {
                    return ['status'=>false, 'message'=>'Voucher sudah diklaim'];
                }

                DB::table('vouchers')->where('id',$voucherId)->update([
                    'claimed' => 1,
                    'claimed_at' => now(),
                    'claimed_reference' => bin2hex(random_bytes(6)),
                ]);

                DB::table('voucher_claims')->insert([
                    'voucher_id' => $voucherId,
                    'claimed_by_user_id' => auth()->check() ? auth()->id() : null,
                    'claimed_ip' => $request->ip(),
                    'note' => 'claimed via promo page',
                ]);

                return [
                    'status'=>true,
                    'message'=>'Voucher berhasil diklaim',
                    'code'=>$voucher->kode_voucher
                ];

            }, 5);

        } catch (\Throwable $e) {
            return back()->with('error','Terjadi kesalahan: '.$e->getMessage());
        }

        if ($result['status']) {
            return back()->with('success', $result['message'].' (kode: '.$result['code'].')');
        }

        return back()->with('error',$result['message']);
    }
}