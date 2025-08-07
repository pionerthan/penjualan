<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'PenjualanID';
    public $timestamps = true;

    protected $fillable = [
        'TanggalPenjualan',
        'TotalHarga',
        'PelangganID',
        'Pajak',
    ];

    // Relasi ke pelanggan (many-to-one)
    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'PelangganID', 'PelangganID');
    }

    // Relasi ke detail penjualan (one-to-many)
    public function detailPenjualans(): HasMany
    {
        return $this->hasMany(DetailPenjualan::class, 'PenjualanID', 'PenjualanID');
    }

    protected static function booted()
{
    static::creating(function ($penjualan) {
        $penjualan->TanggalPenjualan = now()->format('Y-m-d');
    });
}

}
