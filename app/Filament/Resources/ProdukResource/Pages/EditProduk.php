<?php

namespace App\Filament\Resources\ProdukResource\Pages;

use Illuminate\Support\Facades\Log;
use App\Filament\Resources\ProdukResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\Inventory;

class EditProduk extends EditRecord
{
    protected static string $resource = ProdukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $oldStok = $this->record->getOriginal('Stok');
        $newStok = $this->form->getState()['Stok'];

        Log::info("afterSave triggered for ProdukID: " . $this->record->ProdukID);
        Log::info("Old Stok: $oldStok, New Stok: $newStok");

        if ($newStok > $oldStok) {
            $selisih = $newStok - $oldStok;

            Inventory::create([
                'produk_id' => $this->record->ProdukID,
                'tipe' => 'in',
                'qty' => $selisih,
                'keterangan' => 'Penambahan stok (Edit Produk)',
            ]);

            Log::info("Inventory IN created: qty $selisih");
        } elseif ($newStok < $oldStok) {
            $selisih = $oldStok - $newStok;

            Inventory::create([
                'produk_id' => $this->record->ProdukID,
                'tipe' => 'out',
                'qty' => $selisih,
                'keterangan' => 'Pengurangan stok (Edit Produk)',
            ]);

            Log::info("Inventory OUT created: qty $selisih");
        } else {
            Log::info("Stok tidak berubah, inventory tidak dibuat.");
        }

        // update stok tanpa memicu event afterSave lagi
        $this->record->Stok = $newStok;
        $this->record->saveQuietly();
    }
}
