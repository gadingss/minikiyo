<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Order;
use Illuminate\Support\Carbon;

class WeeklySalesChart extends ChartWidget
{
    protected ?string $heading = 'Trend Penjualan';

    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 1;
    protected ?string $maxHeight = '300px';

    // ✅ filter bawaan Filament
    public ?string $filter = 'week';

    protected function getFilters(): ?array
    {
        return [
            'day' => 'Today',
            'week' => 'This Week',
            'month' => 'This Month',
            'all' => 'All Time',
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $labels = [];
        $data = [];
        $filter = $this->filter;

        if ($filter === 'week') {
            // 📅 7 Hari Terakhir
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i)->format('Y-m-d');
                $labels[] = Carbon::parse($date)->format('D');

                $sum = Order::join('payments', 'orders.id', '=', 'payments.order_id')
                    ->whereDate('orders.created_at', $date)
                    ->where('payments.payment_status', 'paid')
                    ->sum('payments.amount');

                $data[] = (int) $sum;
            }

        } elseif ($filter === 'month') {
            // 📅 Bulan Ini (per tanggal)
            $days = Carbon::now()->daysInMonth;

            for ($i = 1; $i <= $days; $i++) {
                $date = Carbon::now()->startOfMonth()->addDays($i - 1)->format('Y-m-d');
                $labels[] = Carbon::parse($date)->format('d');

                $sum = Order::join('payments', 'orders.id', '=', 'payments.order_id')
                    ->whereDate('orders.created_at', $date)
                    ->where('payments.payment_status', 'paid')
                    ->sum('payments.amount');

                $data[] = (int) $sum;
            }

        } else {
            // 🌍 All Time (per bulan)
            $orders = Order::join('payments', 'orders.id', '=', 'payments.order_id')
                ->where('payments.payment_status', 'paid')
                ->selectRaw('DATE_FORMAT(orders.created_at, "%Y-%m") as month, SUM(payments.amount) as total')
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            foreach ($orders as $row) {
                $labels[] = Carbon::parse($row->month . '-01')->format('M Y');
                $data[] = (float) $row->total;
            }
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Pendapatan (IDR)',
                    'data' => $data,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59,130,246,0.2)',
                ],
            ],
        ];
    }

}
