<?php

namespace App\Filament\Resources\CompletedOrdersResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class OrderStats extends BaseWidget
{
    protected static ?int $sort = 1; // biar muncul di atas

    protected function getStats(): array
    {
        return [
            Stat::make('Total Orders', Order::where('status', 'delivered')->count())
                ->description('All time orders')
                ->icon('heroicon-o-clipboard-document-list')
                ->color('primary'),

            // Stat::make('Open Orders', Order::whereNotIn('status', ['delivered'])->count())
            //     ->description('Orders not yet completed')
            //     ->icon('heroicon-o-clock')
            //     ->color('warning'),

            Stat::make('Total Revenue', 'IDR ' . number_format(Order::where('status', 'delivered')->sum('total'), 0, ',', '.'))
                ->description('Overall earnings')
                ->icon('heroicon-o-currency-dollar')
                ->color('success'),

            Stat::make('Average Price', 'IDR ' . number_format(Order::where('status', 'delivered')->avg('total'), 2, ',', '.'))
                ->description('Average order value')
                ->icon('heroicon-o-chart-bar')
                ->color('info'),
        ];
    }
}
