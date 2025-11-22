<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Penjualan;

class BestSellingTime extends StatsOverviewWidget
{
    protected function getCards(): array
    {
        // Hari paling ramai
        $perDay = Penjualan::selectRaw('DAYNAME(TanggalPenjualan) as hari, COUNT(*) as total')
            ->groupBy('hari')
            ->orderByDesc('total')
            ->first();

        // Jam paling ramai
        $perHour = Penjualan::selectRaw('HOUR(TanggalPenjualan) as jam, COUNT(*) as total')
            ->groupBy('jam')
            ->orderByDesc('total')
            ->first();

        return [
            Card::make('Hari Terbaik Penjualan', $perDay?->hari ?? 'Belum Ada')
                ->description('Paling ramai: ' . ($perDay?->total ?? 0) . ' transaksi'),

            Card::make('Jam Penjualan Terbaik', ($perHour?->jam ?? '-') . ':00')
                ->description('Penjualan terbanyak: ' . ($perHour?->total ?? 0)),
        ];
    }
}
