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
        // Hitungan dasar
        $totalOrders  = Order::count();
        $paidOrders   = Payment::where('payment_status', 'paid')->count();
        $totalRevenue = Payment::where('payment_status', 'paid')->sum('amount');

        return [

            Stat::make('Total Semua Transaksi', number_format($totalOrders))
                ->description('Jumlah order yang pernah dibuat')
                // ->descriptionIcon('lucide-shopping-bag')
                ->color('info'),

            Stat::make('Transaksi Berhasil', number_format($paidOrders))
                ->description('Order yang sudah dibayar')
                // ->descriptionIcon('lucide-check-circle')
                ->color('success'),

            Stat::make('Total Semua Pendapatan', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Pendapatan yang sudah masuk')
                // ->descriptionIcon('lucide-banknote')
                ->color('success'),
        ];
    }
}

