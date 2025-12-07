<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\SalesOrder;
use Filament\Tables\Table;
use Illuminate\Support\Number;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Service\RegionQueryService;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SalesOrderResource\Pages;
use App\Filament\Resources\SalesOrderResource\RelationManagers;

class SalesOrderResource extends Resource
{
    protected static ?string $model = SalesOrder::class;
    protected static ?string $navigationGroup = 'Shop';
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationLabel = 'Orders';


    public static function getNavigationBadge(): ?string
    {
        return (string) SalesOrder::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function infolist(InfoList $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make("Informasi Pesanan Penjualan")
                    ->description("Status & Customer Info")
                    ->schema([
                        TextEntry::make('trx_id')
                            ->label('ID Transaksi')
                            ->inlineLabel(),
                        TextEntry::make('status')
                            ->label('Status Transaksi')
                            ->formatStateUsing(fn($state) => $state->label())
                            ->badge()
                            ->color(fn($state) => match ($state->label()) {
                                'Pesanan Sedang Diproses' => 'gray',
                                'Pesanan di Batalkan' => 'danger',
                                'Pesanan Selesai' => 'success',
                                'Menunggu Pembayaran' => 'warning',
                                'Pesanan Sedang dalam Pengiriman' => 'success'
                            })
                            ->inlineLabel(),
                        TextEntry::make('due_date_at')
                            ->label('Batas Pembayaran')
                            ->inlineLabel(),
                        TextEntry::make('customer_full_name')
                            ->label('Nama Customer')
                            ->inlineLabel(),
                        TextEntry::make('customer_no_telp')
                            ->label('No Telp Customer')
                            ->inlineLabel(),
                        TextEntry::make('customer_email')
                            ->label('Email Customer')
                            ->inlineLabel(),
                        TextEntry::make('address_line')
                            ->label('Alamat Pengiriman')
                            ->inlineLabel()
                            ->formatStateUsing(function ($state, SalesOrder $salesOrder) {
                                $region = app(RegionQueryService::class)->searchRegionByCode($salesOrder->destination_code);

                                return "$state {$region->label}";
                            }),
                        Section::make("Detail Pengiriman")
                            ->collapsed()
                            ->schema([
                                TextEntry::make('shipping_driver')
                                    ->label('Pengiriman')
                                    ->inlineLabel(),
                                TextEntry::make('shipping_kurir')
                                    ->label('Kurir')
                                    ->inlineLabel(),
                                TextEntry::make('shipping_service')
                                    ->label('Service Pengiriman')
                                    ->inlineLabel(),
                                TextEntry::make('shipping_estimated_delivery')
                                    ->label('Estimasi Pengiriman')
                                    ->inlineLabel(),
                                TextEntry::make('shipping_weight')
                                    ->label('Berat Pengiriman')
                                    ->suffix('gram')
                                    ->inlineLabel(),
                                TextEntry::make('shipping_receipt_number')
                                    ->label('Nomer Resi Pengiriman  ')
                                    ->inlineLabel(),
                            ])
                    ]),
                RepeatableEntry::make('items')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nama Barang')
                            ->formatStateUsing(fn($state) => "$state"),
                        TextEntry::make('quantity')
                            ->label('Jumlah Barang'),
                        TextEntry::make('price')
                            ->label('Harga')
                            ->formatStateUsing(fn($state) => Number::currency($state)),
                        TextEntry::make('total')
                            ->label('Total Harga')
                            ->formatStateUsing(fn($state) => Number::currency($state)),
                    ])
                    ->hiddenLabel()
                    ->columnSpanFull()
                    ->columns(4),

                Section::make("Ringkasan Pembayaran & Pengiriman")
                    ->schema([
                        TextEntry::make('payment_label')
                            ->label("Metode Pembayaran")
                            ->inlineLabel(),
                        TextEntry::make('payment_pay_at')
                            ->label("Pembayaran dibayar")
                            ->inlineLabel(),
                        TextEntry::make('sub_total')
                            ->label("Sub Jumlah")
                            ->formatStateUsing(fn($state) => Number::currency($state))
                            ->inlineLabel(),
                        TextEntry::make('shipping_total')
                            ->label("Jumlah Pembayaran Pengiriman")
                            ->formatStateUsing(fn($state) => Number::currency($state))
                            ->inlineLabel(),
                        TextEntry::make('total')
                            ->label("Jumlah Keseluruhan")
                            ->formatStateUsing(fn($state) => Number::currency($state))
                            ->inlineLabel(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("trx_id"),
                TextColumn::make("customer_full_name"),
                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => $state->label())
                    ->badge()
                    ->color(fn($state) => match ($state->label()) {
                        'Pesanan Sedang Diproses' => 'primary',
                        'Pesanan di Batalkan' => 'danger',
                        'Pesanan Selesai' => 'success',
                        'Menunggu Pembayaran' => 'warning',
                        'Pesanan Sedang dalam Pengiriman' => 'success'
                    })
                    ->icon(fn($state) => match ($state->label()) {
                        'Pesanan Sedang Diproses' => 'heroicon-s-arrow-path',
                        'Pesanan di Batalkan' => 'heroicon-s-x-circle',
                        'Pesanan Selesai' => 'heroicon-s-check-circle',
                        'Menunggu Pembayaran' => 'heroicon-s-clock',
                        'Pesanan Sedang dalam Pengiriman' => 'heroicon-s-truck'
                    }),
                TextColumn::make("total")
                    ->formatStateUsing(fn($state) => Number::currency($state))
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSalesOrders::route('/'),
            'view' => Pages\ViewSalesOrder::route('/{record}')
        ];
    }
}
