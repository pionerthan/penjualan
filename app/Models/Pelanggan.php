<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelanggan extends Model
{
    protected $table = 'pelanggan'; // nama tabel di database

    protected $primaryKey = 'PelangganID'; // primary key

    public $timestamps = false; // karena kamu akan pakai created_at dan updated_at

    protected $fillable = [
        'NamaPelanggan',
        'Alamat',
        'NomorTelepon',
    ];

    // Relasi ke Penjualan
    public function penjualans(): HasMany
    {
        return $this->hasMany(Penjualan::class, 'PelangganID', 'PelangganID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
