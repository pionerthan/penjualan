<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdukResource\Pages;
use App\Models\Produk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Select; 

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('NamaProduk')
                    ->label('Nama Produk')
                    ->required()
                    ->maxLength(255),
                TextInput::make('brand')
                    ->label('Brand')
                    ->maxLength(255),
                Select::make('kategori')
                    ->label('Kategori')
                    ->options([
                        'makanan' => 'Makanan',
                        'minuman' => 'Minuman',
                        'elektronik' => 'Elektronik',
                        'lainnya' => 'Lainnya',
                    ])
                    ->required(),
                TextInput::make('Harga')
                    ->label('Harga')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                TextInput::make('Stok')
                    ->label('Stok')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get, $component) {
                        if ($state == 0) {
                            $component->helperText('⚠️ Produk otomatis berstatus OUTSTOCK jika stok = 0.');
                        } else {
                            $component->helperText('');
                        }
                    })
                    ->rule(function ($record) {
                        return function (string $attribute, $value, $fail) use ($record) {
                            if (!$record) return;

                            $oldStok = (int) $record->Stok;
                            $delta = (int)$value - $oldStok;

                            if ($delta > 0) {
                                $stokMasuk = $record->inventories()->where('tipe', 'in')->sum('qty');
                                $stokKeluar = $record->inventories()->where('tipe', 'out')->sum('qty');
                                $stokInventory = $stokMasuk - $stokKeluar;

                                if ($delta > $stokInventory) {
                                    $fail("❌ Tidak bisa menambah stok sebanyak {$delta}. Stok gudang tersisa hanya {$stokInventory}.");
                                }
                            }
                        };
                    }),

                TextInput::make('FotoURL')
                    ->label('URL Foto Produk')
                    ->placeholder('https://example.com/foto.jpg')
                    ->url()
                    ->maxLength(2048),
                Forms\Components\RichEditor::make('deskripsi')
                    ->label('Deskripsi')
                    ->columnSpanFull(),
                Select::make('status')
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
                TextColumn::make('ProdukID')->label('ID')->sortable(),
                TextColumn::make('NamaProduk')->label('Nama Produk')->searchable(),
                TextColumn::make('brand')
                    ->label('Brand')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('kategori')        
                    ->label('Kategori')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('Harga')->label('Harga')->money('IDR', true),
                TextColumn::make('Stok')->label('Stok'),
                Tables\Columns\ImageColumn::make('FotoURL')->label('Foto')->size(60),

                BadgeColumn::make('status')->label('Status')->colors([
                    'success' => 'active',
                    'danger' => 'inactive',
                ])->sortable(),

                BadgeColumn::make('status_stok')->label('Status Stok')->colors([
                    'success' => 'instock',
                    'danger' => 'outstock',
                ])->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options([
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                ]),
                SelectFilter::make('brand')
                    ->label('Brand')
                    ->options(
                Produk::query()
                    ->distinct()
                    ->pluck('brand', 'brand')
                    ->filter()
                    ->toArray()
                ),
                SelectFilter::make('status_stok')->label('Status Stok')->options([
                    'instock' => 'In Stock',
                    'outstock' => 'Out Stock',
                ]),
                SelectFilter::make('kategori')
                    ->label('Kategori')
                    ->options([
                        'makanan' => 'Makanan',
                        'minuman' => 'Minuman',
                        'elektronik' => 'Elektronik',
                        'lainnya' => 'Lainnya',
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'edit' => Pages\EditProduk::route('/{record}/edit'),
            'scan' => Pages\ScanProduk::route('/scan'),
        ];
    }
}
