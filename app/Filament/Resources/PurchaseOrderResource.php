<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseOrderResource\Pages;
use App\Models\PurchaseOrder;
use App\Models\Produk;
use App\Models\InventoryLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PurchaseOrderResource extends Resource
{
    protected static ?string $model = PurchaseOrder::class;

    protected static ?string $navigationGroup = 'Inventaris';
    protected static ?string $navigationIcon = 'heroicon-o-document-plus';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('SupplierID')
                ->relationship('supplier', 'NamaSupplier')
                ->required(),

            Forms\Components\DatePicker::make('TanggalOrder')
                ->required(),

            Forms\Components\Select::make('Status')
                ->options([
                    'pending'   => 'Pending',
                    'received'  => 'Received',
                    'cancelled' => 'Cancelled',
                ])
                ->required(),

            Forms\Components\Repeater::make('detail')
                ->relationship()
                ->schema([
                    Forms\Components\Select::make('ProdukID')
                        ->relationship('produk', 'NamaProduk')
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                            $produk = Produk::find($state);
                            if ($produk) {
                                $set('HargaBeli', $produk->Harga);
                                self::updateTotal($set, $get);
                            }
                        }),

                    Forms\Components\TextInput::make('Jumlah')
                        ->numeric()
                        ->default(1)
                        ->reactive()
                        ->afterStateUpdated(fn ($state, callable $set, callable $get) =>
                            self::updateTotal($set, $get)
                        ),

                    Forms\Components\TextInput::make('HargaBeli')
                        ->numeric()
                        ->disabled()
                        ->dehydrated(true)
                        ->reactive()
                        ->default(0)
                        ->afterStateUpdated(fn ($state, callable $set, callable $get) =>
                            self::updateTotal($set, $get)
                        ),
                ])
                ->columns(3)
                ->reactive(),

            Forms\Components\TextInput::make('TotalHarga')
                ->label('Total Harga (otomatis)')
                ->numeric()
                ->disabled()
                ->dehydrated(true)
                ->default(0)
                ->columnSpanFull(),
        ]);
    }

    protected static function updateTotal($set, $get)
    {
        $detail = $get('detail') ?? [];
        $total = 0;

        foreach ($detail as $item) {
            $jumlah = $item['Jumlah'] ?? 0;
            $harga  = $item['HargaBeli'] ?? 0;
            $total += $jumlah * $harga;
        }

        $set('TotalHarga', $total);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('supplier.NamaSupplier'),
                Tables\Columns\TextColumn::make('TanggalOrder'),
                Tables\Columns\BadgeColumn::make('Status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'received',
                        'danger'  => 'cancelled',
                    ]),
                Tables\Columns\TextColumn::make('TotalHarga')
                    ->label('Total')
                    ->money('IDR', true),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPurchaseOrders::route('/'),
            'create' => Pages\CreatePurchaseOrder::route('/create'),
            'edit'   => Pages\EditPurchaseOrder::route('/{record}/edit'),
        ];
    }
}
