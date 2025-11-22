<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class PurchaseOrderDetail extends Model
{
    protected $table = 'PurchaseOrderDetail';
    protected $primaryKey = 'PurchaseOrderDetailID';
    public $timestamps = false;


    protected $fillable = [
        'PurchaseOrderID', 'ProdukID', 'Jumlah', 'HargaBeli'
    ];


    public function produk() {
        return $this->belongsTo(Produk::class, 'ProdukID');
    }
}