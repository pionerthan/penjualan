<?php

namespace App\Filament\Resources\PenjualanResource\Pages;

use App\Filament\Resources\PenjualanResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Produk;

class CreatePenjualan extends CreateRecord
{
    protected static string $resource = PenjualanResource::class;

    protected function afterCreate(): void
    {
        // Akses semua detail setelah data penjualan disimpan
        foreach ($this->record->detailPenjualans as $detail) {
            $produk = Produk::find($detail->ProdukID);
            if ($produk) {
                $produk->Stok -= $detail->JumlahProduk;
                $produk->save();
            }
        }
    }
}
