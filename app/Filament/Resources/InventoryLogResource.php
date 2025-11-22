<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryLogResource\Pages;
use App\Filament\Resources\InventoryLogResource\RelationManagers;
use App\Models\InventoryLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InventoryLogResource extends Resource
{
    protected static ?string $model = InventoryLog::class;

    protected static ?string $navigationGroup = 'Inventaris';
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('ProdukID')
                ->relationship('produk', 'NamaProduk')
                ->required(),


            Forms\Components\Select::make('Tipe')
                ->options([
                    'masuk' => 'Masuk',
                    'keluar' => 'Keluar',
                ])->required(),


            Forms\Components\TextInput::make('Jumlah')
                ->numeric()->required(),


            Forms\Components\TextInput::make('Keterangan'),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('produk.NamaProduk'),
            Tables\Columns\TextColumn::make('Tipe'),
            Tables\Columns\TextColumn::make('Jumlah'),
            Tables\Columns\TextColumn::make('created_at'),
        ]);
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
            'index' => Pages\ListInventoryLogs::route('/'),
            'create' => Pages\CreateInventoryLog::route('/create'),
            'edit' => Pages\EditInventoryLog::route('/{record}/edit'),
        ];
    }
}
