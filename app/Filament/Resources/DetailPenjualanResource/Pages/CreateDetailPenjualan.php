<?php

namespace App\Filament\Resources\DetailPenjualanResource\Pages;

use App\Filament\Resources\DetailPenjualanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Produk;

class CreateDetailPenjualan extends CreateRecord
{
    protected static string $resource = DetailPenjualanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $produk = Produk::find($data['ProdukID']);

        // Hitung subtotal otomatis
        $data['Subtotal'] = $produk->Harga * $data['JumlahProduk'];

        // Kurangi stok produk
        $produk->Stok -= $data['JumlahProduk'];
        $produk->save();

        return $data;
    }
}
