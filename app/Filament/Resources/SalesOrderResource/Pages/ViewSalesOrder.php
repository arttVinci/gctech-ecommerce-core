<?php

namespace App\Filament\Resources\SalesOrderResource\Pages;

use App\Data\SalesOrderData;
use Filament\Actions\Action;
use App\Service\SalesOrderService;
use App\States\SalesOrder\Pending;
use App\States\SalesOrder\Progress;
use App\States\SalesOrder\Completed;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\SalesOrderResource;

class ViewSalesOrder extends ViewRecord
{
    protected static string $resource = SalesOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Proses')
                ->icon('heroicon-o-arrow-path-rounded-square')
                ->modalWidth('sm')
                ->visible(fn() => in_array(get_class($this->record->status), [
                    Pending::class,
                    Progress::class
                ]))
                ->form(function () {
                    $transitions = $this->record->status->transitionableStates();

                    $opstions = collect($transitions)->mapWithKeys(fn($class) => [
                        $class => (new $class($this->record))->label()
                    ])->toArray();

                    return [
                        Radio::make('status')
                            ->label("Status")
                            ->options($opstions)
                            ->required()
                            ->inline()
                    ];
                })
                ->action(function (array $data) {
                    $this->record->status->transitionTo(data_get($data, 'status'));
                }),
            Action::make('Input Nomer Resi Pengiriman')
                ->icon('heroicon-o-truck')
                ->modalWidth('sm')
                ->modalHeading('Masukan nomer resi')
                ->visible(function () {
                    $status = get_class($this->record->status);

                    $valid_status = [
                        Progress::class,
                        Completed::class
                    ];

                    return in_array($status, $valid_status) && empty($this->record->shipping_receipt_number);
                })
                ->form([
                    TextInput::make('shipping_receipt_number')
                        ->label("Nomer Resi")
                        ->required()
                ])
                ->action(function (array $data) {
                    app(SalesOrderService::class)->updateReceiptNumber(
                        SalesOrderData::fromModel($this->record),
                        data_get($data, 'shipping_receipt_number')
                    );
                })
        ];
    }
}
