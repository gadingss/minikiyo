<?php

namespace App\Filament\Exports;

use App\Models\Order;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;
use Illuminate\Support\Str;
use Filament\Notifications\Notification;

class OrderExporter extends Exporter
{
    protected static ?string $model = Order::class;

    public static function modifySpreadsheet(\PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet): void
    {
        $sheet = $spreadsheet->getActiveSheet();

        // Sisipkan 4 baris kosong agar header Filament tidak menimpa judul
        $sheet->insertNewRowBefore(1, 4);

        // --- JUDUL ---
        $sheet->setCellValue('A1', 'LAPORAN PENJUALAN MINIKIYOKU');
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        // Tanggal
        $sheet->setCellValue('A2', 'Tanggal Export: ' . now()->format('d-m-Y H:i'));
        $sheet->mergeCells('A2:G2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');

        // Header manual
        $headers = ['Order ID', 'Customer', 'Product', 'Qty', 'Total', 'Status', 'Tanggal Order'];
        $col = 'A';

        foreach ($headers as $header) {
            $sheet->setCellValue($col . '3', $header);
            $col++;
        }

        // Bold header baris 3
        $sheet->getStyle('A3:G3')->getFont()->setBold(true);

        // Paksa pointer menulis data mulai baris 4
        $sheet->setSelectedCell('A4');
    }





    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('Order ID'),

            ExportColumn::make('user.full_name')
                ->label('Customer'),

            ExportColumn::make('products')
            ->label('Produk')
            ->state(fn ($record) =>
                $record->items
                    ->map(fn ($item) => $item->product?->name ?? '-')
                    ->implode(', ')),

            ExportColumn::make('qty')
            ->label('Qty')
            ->state(fn ($record) =>
                $record->items
                    ->map(fn ($item) => $item->quantity)
                    ->implode(', ')
            ),

            ExportColumn::make('Total')
                ->state(fn ($record) => optional($record->payment)->amount ?? 0)
                ->formatStateUsing(fn ($state) => Number::currency($state, 'IDR')),

            ExportColumn::make('status')
                ->label('Status'),

            ExportColumn::make('created_at')
                ->label('Tanggal Order')
                ->formatStateUsing(fn ($state) => $state?->format('d-m-Y H:i')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Export selesai. ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' berhasil.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' gagal.';
        }

        return $body;
    }



    // public static function getCompletedNotification(Export $export): ?Notification
    // {
    //     $failed = $export->getFailedRowsCount();
    //     $success = $export->successful_rows;

    //     return Notification::make()
    //         ->title('Export Selesai ✅')
    //         ->body(
    //             "Berhasil export {$success} baris." .
    //             ($failed ? " {$failed} baris gagal." : "")
    //         )
    //         ->success()
    //         ->duration(8000); // 8000 ms = 8 detik
    //         // ->seconds(8); // bisa pilih ini juga
    // }

}
