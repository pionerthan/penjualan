<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VoucherResource\Pages;
use App\Filament\Resources\VoucherResource\RelationManagers;
use App\Models\Voucher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VoucherResource extends Resource
{
    protected static ?string $model = Voucher::class;

    protected static ?string $navigationGroup = 'Promosi';
    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode_voucher')
                    ->label('Kode voucher')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('diskon_persen')
                    ->label('Diskon (%)')
                    ->suffix('%'),
                Forms\Components\DatePicker::make('mulai_berlaku')
                    ->label('Mulai Berlaku')
                    ->required(),
                Forms\Components\DatePicker::make('kadaluarsa')
                    ->label('Kadaluarsa')
                    ->required(),
                Forms\Components\TextInput::make('limit_penggunaan')
                    ->label('Limit penggunaan')
                    ->numeric()
                    ->required()
                    ->minValue(0),   
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('kode_voucher')->searchable(),
                Tables\Columns\TextColumn::make('diskon_persen')->label('Diskon (%)'),
                Tables\Columns\TextColumn::make('mulai_berlaku')->date(),
                Tables\Columns\TextColumn::make('kadaluarsa')->date(),
                Tables\Columns\TextColumn::make('limit_penggunaan'),
                Tables\Columns\TextColumn::make('digunakan'),                
                Tables\Columns\TextColumn::make('created_at')->dateTime(),                
                Tables\Columns\TextColumn::make('updated_at')->dateTime(),                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListVouchers::route('/'),
            'create' => Pages\CreateVoucher::route('/create'),
            'edit' => Pages\EditVoucher::route('/{record}/edit'),
        ];
    }
}
