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
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> f202dc11e1c9280eac50fe08d2aaa638049b59de
>>>>>>> 664d613eb671ee952505110855ffdac2a37313e3
    {
        $oldStok = $this->record->getOriginal('Stok');
        $newStok = $this->form->getState()['Stok'];

        Log::info("afterSave triggered for ProdukID: ".$this->record->ProdukID);
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
        } 
        elseif ($newStok < $oldStok) {
            $selisih = $oldStok - $newStok;

            Inventory::create([
                'produk_id' => $this->record->ProdukID,
                'tipe' => 'out',
                'qty' => $selisih,
                'keterangan' => 'Pengurangan stok (Edit Produk)',
            ]);

            Log::info("Inventory OUT created: qty $selisih");
        } 
        else {
            Log::info("Stok tidak berubah, inventory tidak dibuat.");
        }
<<<<<<< HEAD

        // update stok tanpa trigger event lagi
        $this->record->Stok = $newStok;
        $this->record->saveQuietly();
    }
=======
        $this->record->Stok = $newStok;
        $this->record->saveQuietly();
    }
<<<<<<< HEAD
=======
=======
{
    $oldStok = $this->record->getOriginal('Stok'); 
    $newStok = $this->form->getState()['Stok']; // nilai terbaru dari form

    \Log::info("afterSave triggered for ProdukID: ".$this->record->ProdukID);
    \Log::info("Old Stok: $oldStok, New Stok: $newStok");

    if ($newStok > $oldStok) {
        $selisih = $newStok - $oldStok;
        Inventory::create([
            'produk_id' => $this->record->ProdukID,
            'tipe' => 'in',
            'qty' => $selisih,
            'keterangan' => 'Penambahan stok (Edit Produk)',
        ]);
        \Log::info("Inventory IN created: qty $selisih");
    } elseif ($newStok < $oldStok) {
        $selisih = $oldStok - $newStok;
        Inventory::create([
            'produk_id' => $this->record->ProdukID,
            'tipe' => 'out',
            'qty' => $selisih,
            'keterangan' => 'Pengurangan stok (Edit Produk)',
        ]);
        \Log::info("Inventory OUT created: qty $selisih");
    } else {
        \Log::info("Stok tidak berubah, inventory tidak dibuat.");
    }

    // update model Stok terbaru
    $this->record->Stok = $newStok;
    $this->record->saveQuietly(); // save tanpa memicu afterSave lagi
}

>>>>>>> 3eceda08ca25fb54a8ad6cc03c7d40295de84383
>>>>>>> f202dc11e1c9280eac50fe08d2aaa638049b59de
>>>>>>> 664d613eb671ee952505110855ffdac2a37313e3
}
