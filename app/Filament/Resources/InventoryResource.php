<?php

namespace App\Filament\Resources;

use App\Models\Inventory;
use App\Models\Produk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\InventoryResource\Pages;

class InventoryResource extends Resource
{
    protected static ?string $model = Inventory::class;

    protected static ?string $navigationLabel = 'Inventory';
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $pluralLabel = 'Inventory';
    protected static ?string $navigationGroup = 'Manajemen Stok';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('produk_id')
                ->label('Produk')
                ->options(Produk::all()->pluck('NamaProduk', 'ProdukID'))
                ->searchable()
                ->required(),

            TextInput::make('jumlah')
                ->numeric()
                ->minValue(1)
                ->required(),

            TextInput::make('sumber')
                ->label('Sumber Distributor')
                ->nullable(),

            TextInput::make('keterangan')
                ->label('Keterangan')
                ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('id')->sortable(),
            TextColumn::make('produk.NamaProduk')->label('Produk'),
            TextColumn::make('jumlah')->label('Jumlah'),
            TextColumn::make('sumber'),
            TextColumn::make('keterangan'),
            TextColumn::make('created_at')->dateTime(),
        ]);
    }

    public static function getRelations(): array
    {
        return [];
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
