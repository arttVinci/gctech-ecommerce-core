<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\SpatieTagsInput;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\ProductResource\RelationManagers;
use Filament\Tables\Filters\SelectFilter;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationGroup = 'Shop';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Products';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Media')
                    ->description('Upload gambar produk Anda')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('cover')
                            ->label('Cover Image')
                            ->collection('cover')
                            ->disk('public')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->maxSize(2048)
                            ->helperText('Ukuran maksimal 2MB. Rasio yang direkomendasikan: 1:1 atau 4:3')
                            ->columnSpanFull(),

                        SpatieMediaLibraryFileUpload::make('galery')
                            ->label('Product Gallery')
                            ->collection('galery')
                            ->multiple()
                            ->disk('public')
                            ->image()
                            ->imageEditor()
                            ->maxSize(2048)
                            ->reorderable()
                            ->maxFiles(5)
                            ->helperText('Upload maksimal 5 gambar, ukuran masing-masing maksimal 2MB')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->columns(1),

                Section::make('Informasi Produk')
                    ->description('Detail informasi produk')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama Produk')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state)))
                                    ->helperText('Nama produk akan otomatis mengisi slug'),

                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->helperText('URL-friendly version dari nama produk'),

                                TextInput::make('sku')
                                    ->label('SKU (Stock Keeping Unit)')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(100)
                                    ->helperText('Kode unik produk untuk inventori'),

                                SpatieTagsInput::make('tags')
                                    ->type('collection')
                                    ->label('Tags')
                                    ->helperText('Tekan Enter untuk menambah tag'),
                            ]),
                    ])
                    ->collapsible()
                    ->columns(1),

                Section::make('Harga & Stok')
                    ->description('Informasi harga dan ketersediaan produk')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('price')
                                    ->label('Harga')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->minValue(0)
                                    ->helperText('Harga dalam Rupiah'),

                                TextInput::make('stock')
                                    ->label('Stok')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->helperText('Jumlah stok tersedia'),

                                TextInput::make('weight')
                                    ->label('Berat')
                                    ->required()
                                    ->numeric()
                                    ->suffix('gram')
                                    ->minValue(0)
                                    ->helperText('Berat untuk kalkulasi ongkir'),
                            ]),
                    ])
                    ->collapsible()
                    ->columns(1),

                Section::make('Deskripsi')
                    ->description('Deskripsi lengkap tentang produk')
                    ->schema([
                        MarkdownEditor::make('deskripsi')
                            ->label('Deskripsi Produk')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'link',
                                'bulletList',
                                'orderedList',
                                'heading',
                            ])
                            ->helperText('Gunakan markdown untuk formatting teks'),
                    ])
                    ->collapsible()
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover')
                    ->label('Cover')
                    ->getStateUsing(fn($record) => $record->getFirstMediaUrl('cover'))
                    ->circular()
                    ->size(50)
                    ->defaultImageUrl(url('/images/placeholder.png')),

                TextColumn::make('name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 30) {
                            return null;
                        }
                        return $state;
                    }),

                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('SKU copied!')
                    ->copyMessageDuration(1500)
                    ->badge()
                    ->color('gray'),

                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable()
                    ->weight('bold')
                    ->color('success'),

                TextColumn::make('stock')
                    ->label('Stok')
                    ->sortable()
                    ->badge()
                    ->color(fn(string $state): string => match (true) {
                        $state == 0 => 'danger',
                        $state <= 10 => 'warning',
                        default => 'success',
                    })
                    ->formatStateUsing(fn(string $state): string => match (true) {
                        $state == 0 => 'Out of Stock',
                        $state <= 10 => $state . ' (Low Stock)',
                        default => $state,
                    }),

                TextColumn::make('weight')
                    ->label('Berat')
                    ->suffix(' gr')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('stock')
                    ->options([
                        'in_stock' => 'In Stock',
                        'low_stock' => 'Low Stock',
                        'out_of_stock' => 'Out of Stock',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'] === 'in_stock',
                            fn(Builder $query): Builder => $query->where('stock', '>', 10),
                        )->when(
                            $data['value'] === 'low_stock',
                            fn(Builder $query): Builder => $query->whereBetween('stock', [1, 10]),
                        )->when(
                            $data['value'] === 'out_of_stock',
                            fn(Builder $query): Builder => $query->where('stock', 0),
                        );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->color('info'),
                Tables\Actions\EditAction::make()
                    ->color('warning'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->emptyStateHeading('Belum ada produk')
            ->emptyStateDescription('Mulai tambahkan produk pertama Anda')
            ->emptyStateIcon('heroicon-o-shopping-bag')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Produk')
                    ->icon('heroicon-o-plus'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 0 ? 'success' : 'gray';
    }
}
