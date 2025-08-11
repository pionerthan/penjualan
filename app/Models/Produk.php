<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'ProdukID';
    public $timestamps = true;

    protected $fillable = [
        'NamaProduk',
        'Harga',
        'Stok',
        'FotoURL',
        'status',
        'status_stok',

    ];

    protected static function booted()
    {
        static::saving(function ($produk) {
            if ($produk->Stok > 0) {
                $produk->status_stok = 'instock';
            } else {
                $produk->status_stok = 'outstock';
            }
        });
    }

    // Relasi ke detail penjualan
    public function detailPenjualans(): HasMany
    {
        return $this->hasMany(DetailPenjualan::class, 'ProdukID', 'ProdukID');
    }
}
