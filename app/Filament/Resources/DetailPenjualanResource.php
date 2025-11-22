<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DetailPenjualanResource\Pages;
use App\Filament\Resources\DetailPenjualanResource\RelationManagers;
use App\Models\DetailPenjualan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;


class DetailPenjualanResource extends Resource
{
    protected static ?string $model = DetailPenjualan::class;

    protected static ?string $navigationGroup = 'Penjualan';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Select::make('PenjualanID')
                ->label('Penjualan')
                ->relationship('penjualan', 'PenjualanID')
                ->required(),

            Forms\Components\Select::make('ProdukID')
                ->label('Produk')
                ->relationship('produk', 'NamaProduk')
                ->searchable()
                ->required(),

            Forms\Components\TextInput::make('JumlahProduk')
                ->label('Jumlah')
                ->numeric()
                ->required(),

            Forms\Components\TextInput::make('Subtotal')
                ->label('Subtotal')
                ->numeric()
                ->prefix('Rp')
                ->required(),
        ]);
}


    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('DetailID')->label('ID')->sortable(),
            Tables\Columns\TextColumn::make('penjualan.PenjualanID')->label('Penjualan'),
            Tables\Columns\TextColumn::make('produk.NamaProduk')->label('Produk'),
            Tables\Columns\TextColumn::make('JumlahProduk')->label('Jumlah'),
            Tables\Columns\TextColumn::make('Subtotal')->label('Subtotal')->money('IDR', true),
        ])
        ->filters([
            //
        ])
        ->actions([
    Tables\Actions\ViewAction::make(),
    Tables\Actions\EditAction::make(),
    Tables\Actions\DeleteAction::make(),
])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
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
            'index' => Pages\ListDetailPenjualans::route('/'),
            'create' => Pages\CreateDetailPenjualan::route('/create'),
            'edit' => Pages\EditDetailPenjualan::route('/{record}/edit'),
        ];
    }
}
