<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPenjualan extends Model
{
    protected $table = 'detailpenjualan';
    protected $primaryKey = 'DetailID';
    public $timestamps = true;

    protected $fillable = [
        'PenjualanID',
        'ProdukID',
        'JumlahProduk',
        'Subtotal',
    ];

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
