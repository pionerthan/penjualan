<?php

namespace App\Filament\Resources\PelangganResource\RelationManagers;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;

class PenjualansRelationManager extends RelationManager
{
    protected static string $relationship = 'penjualans';

    public function table(Table $table): Table
    {
            return $table
                ->columns([
                    Tables\Columns\TextColumn::make('PenjualanID')
                        ->label('ID')
                        ->sortable(),
                    Tables\Columns\TextColumn::make('TanggalPenjualan')
                        ->label('Tanggal')
                        ->dateTime('d/m/Y H:i'),
                    Tables\Columns\TextColumn::make('TotalHarga')
                        ->label('Total')
                        ->money('IDR'),    
                    
                    Tables\Columns\TextColumn::make('detailPenjualans.produk.NamaProduk')
                        ->label('Barang Dibeli')
                        ->listWithLineBreaks()
                        ->Limit(50),
                ])
                ->filters([])
                ->headerActions([])
                ->actions([])
                ->bulkActions([]);
    }
}

?>