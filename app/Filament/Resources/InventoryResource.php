<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryResource\Pages;
use App\Models\Inventory;
use App\Models\Produk;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

class InventoryResource extends Resource
{
    protected static ?string $model = Inventory::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Manajemen Produk';
    protected static ?string $navigationLabel = 'Inventory';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Select::make('produk_id')
                ->label('Produk')
                ->options(Produk::all()->pluck('NamaProduk', 'ProdukID'))
                ->searchable()
                ->required(),

            Select::make('tipe')
                ->label('Tipe Transaksi')
                ->options([
                    'in' => 'Stok Masuk',
                    'out' => 'Stok Keluar'
                ])
                ->required(),

            TextInput::make('qty')
                ->label('Jumlah')
                ->numeric()
                ->required(),

            Textarea::make('keterangan')
                ->label('Keterangan')
                ->rows(3),

                
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            TextColumn::make('produk.NamaProduk')->label('Produk'),
            TextColumn::make('tipe')->label('Tipe'),
            TextColumn::make('qty')->label('Jumlah'),
            TextColumn::make('created_at')->dateTime('d/m/Y'),

            ])
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([]);

    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInventories::route('/'),
            'create' => Pages\CreateInventory::route('/create'),
            'edit' => Pages\EditInventory::route('/{record}/edit'),
        ];
    }
}