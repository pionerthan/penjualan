<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'produk_id',
        'tipe',
        'qty',
        'keterangan',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'ProdukID');
    }
}
