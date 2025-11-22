<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = 'PurchaseOrder';
    protected $primaryKey = 'PurchaseOrderID';

    protected $fillable = [
        'SupplierID',
        'TanggalOrder',
        'Status',
        'TanggalDiterima',
        'TotalHarga'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'SupplierID');
    }

    public function detail()
    {
        return $this->hasMany(PurchaseOrderDetail::class, 'PurchaseOrderID');
    }

    protected static function booted()
    {
        static::updated(function ($po) {
            $statusLama = strtolower($po->getOriginal('Status'));
            $statusBaru = strtolower($po->Status);

            if ($statusLama !== 'received' && $statusBaru === 'received') {
                if (!$po->TanggalDiterima) {
                    $po->updateQuietly(['TanggalDiterima' => now()]);
                }

                $po->loadMissing('detail');

                foreach ($po->detail as $detail) {
                    \App\Models\InventoryLog::create([
                        'ProdukID'   => $detail->ProdukID,
                        'Tipe'       => 'masuk',
                        'Jumlah'     => $detail->Jumlah,
                        'Keterangan' => 'PO diterima - ID: '.$po->PurchaseOrderID,
                    ]);

                    $produk = \App\Models\Produk::find($detail->ProdukID);
                    if ($produk) {
                        $produk->increment('Stok', $detail->Jumlah);
                    }
                }
            }
        });
    }
}
