<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Tables;
use App\Models\Order;
use Filament\Actions\ExportAction;
use Filament\Actions\ExportBulkAction;
use App\Filament\Exports\OrderExporter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Carbon;
use UnitEnum;
use BackedEnum;

class SalesReportPage extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationLabel = 'Sales Report';
    protected static string|UnitEnum|null $navigationGroup = 'Reports';
    protected static ?string $slug = 'sales-report';
    protected static ?string $title = 'Sales Report';
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-chart-bar';

    // ----------------------------------------
    // Table setup
    // ----------------------------------------
    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Order::query()
            ->whereHas('payment', fn($q) => $q->where('payment_status', 'paid'))
            ->with(['user', 'payment', 'items.product']);
    }

    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('duration')
                ->label('Filter Waktu')
                ->options([
                    'week' => 'This Week',
                    'month' => 'This Month',
                    'all' => 'All Time',
                ])
                ->default('week')
                ->query(function ($query, $state) {
                    if ($state === 'week') {
                        return $query->whereBetween('orders.created_at', [
                            Carbon::now()->startOfWeek(),
                            Carbon::now()->endOfWeek(),
                        ]);
                    }

                    if ($state === 'month') {
                        return $query
                            ->whereMonth('orders.created_at', Carbon::now()->month)
                            ->whereYear('orders.created_at', Carbon::now()->year);
                    }

                    return $query; // all time
                }),
        ];
    }


    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')->label('Order ID'),
            Tables\Columns\TextColumn::make('user.full_name')->label('Customer'),
            Tables\Columns\TextColumn::make('items')
                ->label('Items')
                ->html()
                ->getStateUsing(fn ($record) =>
                    $record->items->map(fn ($item) => $item->product?->name ?? '-')->implode('<br>')
                ),
            Tables\Columns\TextColumn::make('qty')
                ->label('Qty')
                ->html()
                ->getStateUsing(fn ($record) =>
                    $record->items->map(fn ($item) => $item->quantity)->implode('<br>')
                ),
            Tables\Columns\TextColumn::make('payment.amount')
                ->label('Total')
                ->money('idr')
                ->sortable()
                ->getStateUsing(fn ($record) => $record->payment->amount ?? '-'),
            Tables\Columns\TextColumn::make('created_at')->date()->label('Tanggal'),
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->label('Export')
                ->exporter(OrderExporter::class)
                ->modifyQueryUsing(function ($query, $livewire) {
                    $filter = $livewire->tableFilters['duration'] ?? 'week';

                    if ($filter === 'week') {
                        return $query->whereBetween('orders.created_at', [
                            now()->startOfWeek(),
                            now()->endOfWeek(),
                        ]);
                    }

                    if ($filter === 'month') {
                        return $query
                            ->whereMonth('orders.created_at', now()->month)
                            ->whereYear('orders.created_at', now()->year);
                    }

                    return $query; // all time
                }),
        ];
    }


    protected function getTableBulkActions(): array
    {
        return [
            ExportBulkAction::make()
                ->label('Export Selected')
                ->exporter(OrderExporter::class)
        ];
    }

    // ----------------------------------------
    // Render table di halaman
    // ----------------------------------------
    public function getView(): string
    {
        return 'filament.pages.sales-report-page';
    }
}
