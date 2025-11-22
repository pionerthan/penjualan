<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPenjualan extends Model
{
    protected $table = 'Detailpenjualan'; 
    protected $primaryKey = 'DetailID';
    public $timestamps = true;

    protected $fillable = [
        'PenjualanID',
        'ProdukID',
        'JumlahProduk',
        'Subtotal',
    ];

    protected static function booted()
    {
        static::created(function ($detail) {

            // 1. Simpan log barang keluar
            InventoryLog::create([
                'ProdukID'   => $detail->ProdukID,
                'Tipe'       => 'keluar',
                'Jumlah'     => $detail->JumlahProduk,
                'Keterangan' => 'Penjualan ID: ' . $detail->PenjualanID,
            ]);

            // 2. Update stok di tabel Produk
            $produk = Produk::find($detail->ProdukID);

            if ($produk) {
                $produk->Stok -= $detail->JumlahProduk;
                $produk->save();
            }
        });
    }

    // Relasi ke Penjualan (many-to-one)
    public function penjualan(): BelongsTo
    {
        return $this->belongsTo(Penjualan::class, 'PenjualanID', 'PenjualanID');
    }

    // Relasi ke Produk (many-to-one)
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'ProdukID', 'ProdukID');
    }
}
