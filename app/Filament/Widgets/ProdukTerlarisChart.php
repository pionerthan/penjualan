<?php

namespace App\Filament\Widgets;

use Filament\Widgets\DoughnutChartWidget;
use App\Models\DetailPenjualan;
use App\Models\Produk;

class ProdukTerlarisChart extends DoughnutChartWidget
{
    protected static ?string $heading = 'Produk Terlaris';

    protected function getData(): array
    {
        $data = DetailPenjualan::selectRaw('ProdukID, SUM(JumlahProduk) as total')
            ->groupBy('ProdukID')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $labels = Produk::whereIn('ProdukID', $data->pluck('ProdukID'))
            ->pluck('NamaProduk', 'ProdukID');

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Terjual',
                    'data' => $data->pluck('total'),
                ],
            ],
            'labels' => $data->pluck('ProdukID')->map(fn ($id) => $labels[$id] ?? 'Produk'),
        ];
    }
}
