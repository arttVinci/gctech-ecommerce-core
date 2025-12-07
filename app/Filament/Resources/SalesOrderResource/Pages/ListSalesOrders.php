<?php

namespace App\Filament\Resources\SalesOrderResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\SalesOrderResource;
use App\Filament\Resources\SalesOrderResource\Widgets\SalesOrdersOverview;

class ListSalesOrders extends ListRecords
{
    protected static string $resource = SalesOrderResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            SalesOrdersOverview::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
