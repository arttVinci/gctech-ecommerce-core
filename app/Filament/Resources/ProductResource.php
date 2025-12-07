<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
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


class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationGroup = 'Shop';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';

    protected static ?string $navigationLabel = 'Products';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                SpatieMediaLibraryFileUpload::make('cover')
                    ->collection('cover')
                    ->disk('public'),

                SpatieMediaLibraryFileUpload::make('galery')
                    ->collection('galery')
                    ->multiple()
                    ->disk('public'),

                TextInput::make('name')
                    ->label('Nama Product'),

                TextInput::make('sku')
                    ->unique(ignoreRecord: true)
                    ->label('SKU'),

                TextInput::make('slug')
                    ->unique(ignoreRecord: true)
                    ->label('Slug'),

                SpatieTagsInput::make('tags')
                    ->type('collection')
                    ->Label('Tags Name'),

                TextInput::make('stock')
                    ->numeric()
                    ->default(0)
                    ->label('Stock Product'),

                TextInput::make('price')
                    ->numeric()
                    ->prefix('Rp')
                    ->label('Price/Harga Product'),

                TextInput::make('weight')
                    ->numeric()
                    ->suffix('gram')
                    ->label('Weight'),

                MarkdownEditor::make('deskripsi')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover')
                    ->label('Cover')
                    ->getStateUsing(fn($record) => $record->getFirstMediaUrl('cover')) // ambil url dari media library
                    ->square()
                    ->size(60),

                TextColumn::make('name')->label('Nama Produk'),
                TextColumn::make('sku')->label('SKU'),
                TextColumn::make('slug')->label('Slug'),
                TextColumn::make('stock')->label('Stock'),
                TextColumn::make('price')->label('Price'),
                TextColumn::make('weight')->label('Weight'),
                TextColumn::make('deskripsi')->label('Deskripsi'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
