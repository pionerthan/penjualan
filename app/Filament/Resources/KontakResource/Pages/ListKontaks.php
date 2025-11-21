<?php

namespace App\Filament\Resources\KontakResource\Pages;

use App\Models\Kontak;
use App\Filament\Resources\KontakResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKontaks extends ListRecords
{
    protected static string $resource = KontakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 664d613eb671ee952505110855ffdac2a37313e3
