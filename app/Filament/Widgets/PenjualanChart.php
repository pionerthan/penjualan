<?php

namespace App\Filament\Widgets;

use App\Models\Penjualan;
use Filament\Widgets\LineChartWidget;

class PenjualanChart extends LineChartWidget
{
    protected static ?string $heading = 'Grafik Penjualan';

    protected function getData(): array
    {
        // Ambil penjualan dalam 30 hari terakhir
        $data = Penjualan::selectRaw('DATE(TanggalPenjualan) as tanggal, status_penjualan, COUNT(*) as total')
            ->whereDate('TanggalPenjualan', '>=', now()->subDays(30))
            ->groupBy('tanggal', 'status_penjualan')
            ->orderBy('tanggal')
            ->get();

        // Siapkan array tanggal
        $dates = [];
        $totalSelesai = [];
        $totalDibatalkan = [];

        // Loop semua 30 hari terakhir
        foreach (range(30, 0) as $i) {
            $day = now()->subDays($i)->format('Y-m-d');
            $dates[] = $day;

            $selesai = $data->where('tanggal', $day)->where('status_penjualan', 'selesai')->sum('total');
            $batal = $data->where('tanggal', $day)->where('status_penjualan', 'batal')->sum('total');

            $totalSelesai[] = $selesai;
            $totalDibatalkan[] = -$batal;  // grafik turun (nilai minus)
        }

        return [
            'datasets' => [
                [
                    'label' => 'Penjualan Selesai',
                    'data' => $totalSelesai,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.7)', // hijau
                ],
                [
                    'label' => 'Penjualan Dibatalkan',
                    'data' => $totalDibatalkan,
                    'backgroundColor' => 'rgba(239, 68, 68, 0.7)', // merah
                ],
            ],
            'labels' => $dates,
        ];
    }
}
