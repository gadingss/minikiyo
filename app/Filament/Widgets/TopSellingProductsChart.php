<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\OrderItem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TopSellingProductsChart extends ChartWidget
{
    protected ?string $heading = 'Produk Terlaris';
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 2;
    protected ?string $maxHeight = '300px';

    // Filter default
    public ?string $filter = 'week';

    // Jenis chart
    protected function getType(): string
    {
        return 'bar';
    }

    // Definisikan filter
    protected function getFilters(): ?array
    {
        return [
            'all' => 'All Time',
            'month' => 'Bulan Ini',
            'week' => 'Minggu Ini',
        ];
    }

    // Data chart sesuai filter aktif
    protected function getData(): array
    {
        $query = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->whereHas('order', fn($q) => $q->whereHas('payment', fn($p) => $p->where('payment_status', 'paid')))
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->limit(5);

        $now = Carbon::now();

        if ($this->filter === 'week') {
            $query->whereBetween('created_at', [$now->startOfWeek(), $now->endOfWeek()]);
        } elseif ($this->filter === 'month') {
            $query->whereMonth('created_at', $now->month)
                  ->whereYear('created_at', $now->year);
        }
        // 'all' = tidak memfilter

        $topProducts = $query->get();

        $labels = $topProducts->map(fn($item) => $item->product?->name ?? 'Unknown')->toArray();
        $data = $topProducts->pluck('total_qty')->toArray();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Jumlah Terjual',
                    'data' => $data,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.7)',
                    'borderColor' => '#3b82f6',
                    'borderWidth' => 1,
                ],
            ],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'x',
            'plugins' => ['legend' => ['display' => false]],
            'scales' => ['y' => ['beginAtZero' => true]],
        ];
    }
}
