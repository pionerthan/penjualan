<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenjualanResource\Pages;
use App\Models\Penjualan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use App\Models\Produk;

class PenjualanResource extends Resource
{
    protected static ?string $model = Penjualan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            DatePicker::make('TanggalPenjualan')
                ->label('Tanggal Penjualan')
                ->required(),

            Select::make('PelangganID')
                ->label('Pelanggan')
                ->relationship('pelanggan', 'NamaPelanggan')
                ->searchable()
                ->required(),

            TextInput::make('TotalHarga')
                ->label('Total Harga')
                ->prefix('Rp')
                ->disabled()
                ->dehydrated(),

            Repeater::make('detailPenjualans')
                ->label('Detail Produk')
                ->relationship()
                ->schema([
                    Select::make('ProdukID')
                        ->label('Produk')
                        ->options(Produk::all()->pluck('NamaProduk', 'ProdukID'))
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            $produk = Produk::find($state);
                            if ($produk) {
                                $set('Harga', $produk->Harga);
                                $set('JumlahProduk', 1);
                                $set('Subtotal', $produk->Harga);
                            }
                        }),

                    TextInput::make('Harga')
                        ->label('Harga')
                        ->prefix('Rp')
                        ->disabled()
                        ->dehydrated(),

                    TextInput::make('JumlahProduk')
                        ->label('Jumlah')
                        ->numeric()
                        ->minValue(1)
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                            $harga = $get('Harga') ?? 0;
                            $subtotal = $harga * (int) $state;
                            $set('Subtotal', $subtotal);

                            // update total harga
                            $details = $get('../../detailPenjualans');
                            $total = collect($details)->sum(fn ($item) => $item['Subtotal'] ?? 0);
                            $set('../../TotalHarga', $total);
                        }),

                    TextInput::make('Subtotal')
                        ->label('Subtotal')
                        ->prefix('Rp')
                        ->disabled()
                        ->dehydrated(),
                ])
                ->columns(3)
                ->required()
        ]);
}


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('PenjualanID')->label('ID')->sortable(),
                TextColumn::make('TanggalPenjualan')->label('Tanggal'),
                TextColumn::make('pelanggan.NamaPelanggan')->label('Pelanggan'),
                TextColumn::make('TotalHarga')->label('Total')->money('IDR', true),
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
        return [];
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
