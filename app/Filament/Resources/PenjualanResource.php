<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenjualanResource\Pages;
use App\Filament\Resources\PenjualanResource\RelationManagers;
use App\Models\Penjualan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;


class PenjualanResource extends Resource
{
    protected static ?string $model = Penjualan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\DatePicker::make('TanggalPenjualan')
                ->label('Tanggal Penjualan')
                ->required(),

            Forms\Components\Select::make('PelangganID')
                ->label('Pelanggan')
                ->relationship('pelanggan', 'NamaPelanggan')
                ->searchable()
                ->required(),

            Forms\Components\TextInput::make('TotalHarga')
                ->label('Total Harga')
                ->numeric()
                ->prefix('Rp')
                ->required(),

            Forms\Components\Repeater::make('detailPenjualans')
                ->label('Detail Produk')
                ->relationship()
                ->schema([
                    Forms\Components\Select::make('ProdukID')
                        ->label('Produk')
                        ->relationship('produk', 'NamaProduk')
                        ->required(),
                    Forms\Components\TextInput::make('JumlahProduk')
                        ->numeric()
                        ->required(),
                    Forms\Components\TextInput::make('Subtotal')
                        ->numeric()
                        ->prefix('Rp')
                        ->required(),
                ])
                ->columns(3)
                ->columnSpanFull(),
        ]);
}


    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('PenjualanID')->label('ID')->sortable(),
            Tables\Columns\TextColumn::make('TanggalPenjualan')->label('Tanggal'),
            Tables\Columns\TextColumn::make('pelanggan.NamaPelanggan')->label('Pelanggan'),
            Tables\Columns\TextColumn::make('TotalHarga')->label('Total')->money('IDR', true),
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
            'index' => Pages\ListPenjualans::route('/'),
            'create' => Pages\CreatePenjualan::route('/create'),
            'edit' => Pages\EditPenjualan::route('/{record}/edit'),
        ];
    }
}
