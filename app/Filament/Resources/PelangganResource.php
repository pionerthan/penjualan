<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PelangganResource\Pages;
use App\Filament\Resources\PelangganResource\RelationManagers;
use App\Models\Pelanggan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;


class PelangganResource extends Resource
{
    protected static ?string $model = Pelanggan::class;

    protected static ?string $navigationGroup = 'Customer';
    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('NamaPelanggan')
                ->label('Nama Pelanggan')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('Alamat')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('NomorTelepon')
                ->label('Nomor Telepon')
                ->required()
                ->maxLength(15),
        ]);
}

public static function getNavigationBadge(): ?string
    {
        return null; // Tidak ada badge
    }


    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('PelangganID')->label('ID')->sortable(),
            Tables\Columns\TextColumn::make('NamaPelanggan')->label('Nama')->searchable(),
            Tables\Columns\TextColumn::make('Alamat')->label('Alamat'),
            Tables\Columns\TextColumn::make('NomorTelepon')->label('Telepon'),
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
            RelationManagers\PenjualansRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPelanggans::route('/'),
            'create' => Pages\CreatePelanggan::route('/create'),
            'view' => Pages\ViewPelanggan::route('/{record}'),
            'edit' => Pages\EditPelanggan::route('/{record}/edit'),
        ];
    }
}
