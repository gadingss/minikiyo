<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Dashboard extends Page
{
    protected string $view = 'filament.pages.dashboard';

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\SalesStats::class,
            \App\Filament\Widgets\WeeklySalesChart::class,
            \App\Filament\Widgets\TopSellingProductsChart::class,
            // \App\Filament\Widgets\SalesReport::class,
        ];
    }

}
