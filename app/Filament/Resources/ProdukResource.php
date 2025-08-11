<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdukResource\Pages;
use App\Filament\Resources\ProdukResource\RelationManagers;
use App\Models\Produk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;


class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('NamaProduk')
                ->label('Nama Produk')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('Harga')
                ->numeric()
                ->prefix('Rp')
                ->required(),

            Forms\Components\TextInput::make('Stok')
                ->numeric()
                ->required(),

            Forms\Components\TextInput::make('FotoURL')
            ->label('URL Foto Produk')
            ->placeholder('https://example.com/foto.jpg')
            ->url() // validasi bahwa ini URL
            ->maxLength(2048),

            Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                ])
                ->default('active')
                ->required(),
        ]);
}

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('ProdukID')->label('ID')->sortable(),
            Tables\Columns\TextColumn::make('NamaProduk')->label('Nama Produk')->searchable(),
            Tables\Columns\TextColumn::make('Harga')->label('Harga')->money('IDR', true),
            Tables\Columns\TextColumn::make('Stok')->label('Stok'),
            Tables\Columns\ImageColumn::make('FotoURL')
                ->label('Foto')
                ->size(60),
            BadgeColumn::make('status')
                ->label('Status')
                ->colors([
                    'success' => 'active',
                    'danger' => 'inactive',
                ])
                ->sortable(),

            BadgeColumn::make('status_stok')
                ->label('Status Stok')
                ->colors([
                    'success' => 'active',
                    'danger' => 'inactive',
                ])
                ->sortable(),

        ])
        ->filters([
            SelectFilter::make('status')
                ->options([
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                ]),
            SelectFilter::make('status_stok')
                ->label('Status Stok')
                ->options([
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                ]), 

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
            'index' => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'edit' => Pages\EditProduk::route('/{record}/edit'),
        ];
    }
}
