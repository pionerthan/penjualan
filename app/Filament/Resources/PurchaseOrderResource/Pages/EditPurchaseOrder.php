<?php

namespace App\Filament\Resources\PurchaseOrderResource\Pages;

use App\Filament\Resources\PurchaseOrderResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms;

class EditPurchaseOrder extends EditRecord
{
    protected static string $resource = PurchaseOrderResource::class;

    protected function mutateFormSchema(array $schema): array
    {
        $schema[] = Forms\Components\Select::make('Status')
            ->label('Status Purchase Order')
            ->options([
                'pending' => 'Pending',
                'received' => 'Received',
                'cancelled' => 'Cancelled',
            ])
            ->required()
            ->columnSpanFull();

        return $schema;
    }

}
