<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KontakResource\Pages;
use App\Models\Kontak;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KontakResource extends Resource
{
    protected static ?string $model = \App\Models\Kontak::class;
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationGroup = 'Mail';
    protected static ?string $navigationLabel = 'Pesan Masuk';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama')->disabled(),
            Forms\Components\TextInput::make('email')->disabled(),
            Forms\Components\TextInput::make('subjek')->disabled(),
            Forms\Components\Textarea::make('pesan')->rows(8)->disabled(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('nama')->label('Nama')->searchable(),
            Tables\Columns\TextColumn::make('email')->label('Email')->searchable(),
            Tables\Columns\TextColumn::make('subjek')->label('Subjek')->searchable(),
            Tables\Columns\TextColumn::make('created_at')->label('Dikirim')->dateTime(),
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKontaks::route('/'),
            'view' => Pages\ViewKontak::route('/{record}'),
        ];
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 664d613eb671ee952505110855ffdac2a37313e3
