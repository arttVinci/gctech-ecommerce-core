<?php

namespace App\Filament\Resources\SalesOrderResource\Widgets;

use App\Models\SalesOrder;
use App\States\SalesOrder\Progress;
use App\States\SalesOrder\Completed;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class SalesOrdersOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $totalOrders = SalesOrder::count();
        $pendingOrders = SalesOrder::where('status', Progress::class)->count();
        $completedOrders = SalesOrder::where('status', Completed::class)->count();
        $averagePrice = SalesOrder::avg('total');

        return [
            Stat::make('Pesanan', number_format($totalOrders))
                ->chart([5, 10, 3, 12, 8, 6, 15])
                ->description('Total orders')
                ->descriptionIcon('heroicon-o-shopping-bag'),

            Stat::make('Pending Orders', number_format($pendingOrders))
                ->description('Menunggu konfirmasi')
                ->icon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('Completed Orders', number_format($completedOrders))
                ->description('Pesanan selesai')
                ->icon('heroicon-o-truck')
                ->color('success'),

            Stat::make('Average price', number_format($averagePrice, 2))
                ->description('Average total per order')
                ->descriptionIcon('heroicon-o-currency-dollar'),
        ];
    }
}
