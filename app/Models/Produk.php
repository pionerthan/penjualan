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
    ];

    // Relasi ke detail penjualan
    public function detailPenjualans(): HasMany
    {
        return $this->hasMany(DetailPenjualan::class, 'ProdukID', 'ProdukID');
    }
}
