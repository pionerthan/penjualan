<?php

namespace App\Filament\Resources\ProdukResource\Pages;

use App\Filament\Resources\ProdukResource;
use Filament\Resources\Pages\Page;
use App\Models\Produk;
use Filament\Notifications\Notification;

class ScanProduk extends Page
{
    protected static string $resource = ProdukResource::class;

    protected static string $view = 'filament.resources.produk-resource.pages.scan-produk';

    protected static ?string $title = 'Scan Produk';

    public $barcode;

    public function simpanProduk()
    {
        Produk::create([
            'NamaProduk' => 'Produk Baru', // isi default biar gak error
            'barcode' => $this->barcode,
            'status' => 'active',
            'status_stok' => 'instock',
            'Harga' => 0,
            'Stok' => 0,
        ]);

        $this->reset('barcode');

        Notification::make()
            ->title('Produk berhasil ditambahkan!')
            ->success()
            ->send();
    }
}
