<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class InventoryLog extends Model
{
    protected $table = 'InventoryLog';
    protected $primaryKey = 'InventoryLogID';
    public $timestamps = false;

    protected $fillable = [
        'ProdukID', 'Tipe', 'Jumlah', 'Keterangan'
    ];

    protected static function booted()
    {
        static::created(function ($log) {
            $produk = Produk::find($log->ProdukID);

            if ($log->Tipe === 'masuk') {
                $produk->Stok += $log->Jumlah;
            } else {
                $produk->Stok -= $log->Jumlah;
            }

            $produk->save();
        });
    }

    public function produk() {
        return $this->belongsTo(Produk::class, 'ProdukID');
    }
}
