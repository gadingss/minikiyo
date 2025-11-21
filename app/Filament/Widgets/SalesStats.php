<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Order;
use App\Models\Payment;

class SalesStats extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Semua Transaksi', Order::count()),

            Stat::make('Transaksi Berhasil', Payment::where('payment_status', 'paid')->count()),

            Stat::make('Total Semua Pendapatan', 'Rp ' . number_format(
                Payment::where('payment_status', 'paid')->sum('amount')
            )),
        ];
    }
}
