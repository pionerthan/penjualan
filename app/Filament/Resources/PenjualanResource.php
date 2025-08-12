<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenjualanResource\Pages;
use App\Models\Penjualan;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
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
            TextInput::make('TanggalPenjualan')
                ->label('Tanggal Penjualan')
                ->default(now()->format('Y-m-d H:i:s'))
                ->readOnly(),

            Select::make('PelangganID')
                ->label('Pelanggan')
                ->relationship('pelanggan', 'NamaPelanggan')
                ->searchable()
                ->required(),

            TextInput::make('TotalHarga')
                ->label('Total Harga')
                ->prefix('Rp')
                ->disabled()
                ->dehydrated()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set){
                    $set('Pajak', $state * 0.11);
                }),

            TextInput::make('Pajak')
                ->label('pajak (11%)')
                ->disabled()
                ->numeric()
                ->prefix('Rp')
                ->reactive()
                ->dehydrated(),

            Select::make('voucher_id')
                ->label('kode_voucher')
                ->relationship('voucher', 'kode_voucher', fn ($query) =>
                    $query->whereDate('mulai_berlaku', '<=', now())
                          ->whereDate('kadaluarsa', '>=', now())
                          ->where(function($q){
                            $q->whereColumn('digunakan', '<', 'limit_penggunaan')
                              ->orWhere('limit_penggunaan', 0);
                          })
                    )
                    ->searchable()
                    ->nullable()        
                    ->reactive()        
                    ->afterStateUpdated(function($state, callable $set, Get $get) {
                        $details = $get('detailPenjualans');
                        $subtotal = collect($details)->sum(fn ($item) => $item['Subtotal'] ?? 0);

                        $pajak = $subtotal * 0.11;
                        $totalSetelahPajak = $subtotal + $pajak;

                        $diskonPersen = 0;
                        if ($state) {
                            $voucher = \App\Models\Voucher::find($state);
                            if ($voucher) {
                                $diskonPersen = $voucher->diskon_persen ?? 0;
                            }
                        }

                        $diskonNominal = $totalSetelahPajak * ($diskonPersen / 100);
                        $totalAkhir = $totalSetelahPajak - ($totalSetelahPajak * ($diskonPersen / 100));

                        $set('diskon_persen', $diskonPersen);
                        $set('harga_setelah_diskon', $diskonNominal);
                        $set('Pajak', $pajak);
                        $set('TotalHarga', $totalAkhir);
                    }),
                    
            TextInput::make('diskon_persen')
                ->label('Diskon (%)')
                ->disabled(),

            TextInput::make('harga_setelah_diskon')
                ->label('Diskon')
                ->prefix('Rp')
                ->disabled(),

            Repeater::make('detailPenjualans')
                ->label('Detail Produk')
                ->relationship()
                ->schema([
                    Select::make('ProdukID')
                        ->label('Produk')
                        ->options(Produk::all()->pluck('NamaProduk', 'ProdukID'))
                        ->required()
                        ->reactive()
                        ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                        ->afterStateUpdated(function ($state, callable $set, Get $get) {
                            $produk = Produk::find($state);
                            if ($produk) {
                                $set('Harga', $produk->Harga);
                                $set('JumlahProduk', 1);
                                $set('Subtotal', $produk->Harga);

                                $details = $get('../../detailPenjualans');
                                $total = collect($details)->sum(fn ($item) => $item['Subtotal'] ?? 0);
                                
                                $pajak = $total * 0.11;
                                $set('../../Pajak', $pajak);

                                $totalAkhir = $total + $pajak;

                                $diskonNominal = 0;
                                $voucherId = $get('../../voucher_id');
                                if ($voucherId) {
                                    $voucher = \App\Models\Voucher::find($voucherId);
                                    if ($voucher) {
                                        $diskonPersen = $voucher->diskon_persen ?? 0;
                                        $diskonNominal = $totalAkhir * ($diskonPersen / 100);

                                        $set('../../diskon_persen', $diskonPersen);
                                        $set('../../harga_setelah_diskon', $diskonNominal);
                                    }
                                }

                                $totalAkhir -= $diskonNominal;
                                $set('../../TotalHarga', max(0, $totalAkhir));

                            }
                        }),

                    TextInput::make('Harga')
                        ->label('Harga')
                        ->prefix('Rp')
                        ->disabled()
                        ->default(function (Get $get) {
                            $produkId = $get('ProdukID');
                            return $produkId ? Produk::find($produkId)?->Harga : null;
                        })
                        ->formatStateusing(function ($state, $record) {
                            if ($state) {
                                return $state;
                            }
                            if ($record?->ProdukID) {
                                return Produk::find($record->ProdukID)?->Harga;
                            }
                            return null;
                        }),

                    TextInput::make('JumlahProduk')
                        ->label('Jumlah')
                        ->numeric()
                        ->minValue(1)
                        ->default(1)
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set, Get $get) {
                            $harga = $get('Harga') ?? 0;
                            $subtotal = $harga * (int) $state;
                            $set('Subtotal', $subtotal);

                            $details = $get('../../detailPenjualans');
                            $total = collect($details)->sum(fn ($item) => $item['Subtotal'] ?? 0);
                            $set('../../TotalHarga', $total);
                            $set('../../Pajak', $pajak);

                                $totalAkhir = $total + $pajak;

                                $diskonNominal = 0;
                                $voucherId = $get('../../voucher_id');
                                if ($voucherId) {
                                    $voucher = \App\Models\Voucher::find($voucherId);
                                    if ($voucher) {
                                        $diskonPersen = $voucher->diskon_persen ?? 0;
                                        $diskonNominal = $totalAkhir * ($diskonPersen / 100);

                                        $set('../../diskon_persen', $diskonPersen);
                                        $set('../../harga_setelah_diskon', $diskonNominal);
                                    }
                                }

                                $totalAkhir -= $diskonNominal;
                                $set('../../TotalHarga', max(0, $totalAkhir));
                        }),

                    TextInput::make('Subtotal')
                        ->label('Subtotal')
                        ->prefix('Rp')
                        ->disabled()
                        ->dehydrated()
                        ->reactive(),
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

    

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $total = $data['TotalHarga'] ?? 0;
        $data['Pajak'] = $total * 0.11;
        return $data;
    }
}
