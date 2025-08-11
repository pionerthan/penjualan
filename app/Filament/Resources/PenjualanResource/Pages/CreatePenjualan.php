<?php

namespace App\Filament\Resources\PenjualanResource\Pages;

use App\Filament\Resources\PenjualanResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Produk;
Use Carbon\Carbon;

class CreatePenjualan extends CreateRecord
{
    protected static string $resource = PenjualanResource::class;

protected function mutateFormDataBeforeCreate(array $data): array
    {
        $total = $data['TotalHarga'] ?? 0;
        $data['Pajak'] = $total * 0.11;

        $data['TanggalPenjualan'] = now();

        return $data;
    }

    protected function afterCreate(): void
    {
        foreach ($this->record->detailPenjualans as $detail) {
            $produk = Produk::find($detail->ProdukID);
            if ($produk) {
                $produk->Stok -= $detail->JumlahProduk;
                $produk->save();
            }
        }

        if ($this->record->voucher_id) {
            $voucher = \App\Models\Voucher::find($this->record->voucher_id);
            if ($voucher) {
                $voucher->increment('digunakan');
            }
        }
    }
}
