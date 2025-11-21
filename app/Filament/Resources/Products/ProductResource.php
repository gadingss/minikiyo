<?php

namespace App\Filament\Resources\Products;

use App\Filament\Resources\Products\Pages;
use App\Models\Product;
use App\Helpers\SupabaseUploader;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use BackedEnum;
use UnitEnum;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-cube';
    protected static UnitEnum|string|null $navigationGroup = 'Manajemen Toko';

    protected static ?string $navigationLabel = 'Produk';
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nama Produk')
                ->required()
                ->maxLength(255),

            Forms\Components\Select::make('category_id')
                ->label('Kategori')
                ->relationship('category', 'name')
                ->searchable()
                ->preload()
                ->required(),

            Forms\Components\TextInput::make('price')
                ->label('Harga (Rp)')
                ->numeric()
                ->required(),

            Forms\Components\TextInput::make('stock_quantity')
                ->label('Stok')
                ->numeric()
                ->required(),

            Forms\Components\Toggle::make('is_active')
                ->label('Produk Aktif')
                ->default(true)
                ->inline(false)
                ->helperText('Nonaktifkan jika produk tidak boleh muncul di client')
                ->required(),


            Forms\Components\Textarea::make('description')
                ->label('Deskripsi')
                ->rows(3),

            Forms\Components\FileUpload::make('image_url')
                ->label('Gambar Produk')
                ->image()
                ->disk('public')
                ->directory('products')
                ->visibility('public')
                ->previewable(true)
                ->downloadable(false)
                ->preserveFilenames(),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Gambar')
                    ->square(),

                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Nama Produk')->searchable(),
                Tables\Columns\TextColumn::make('category.name')->label('Kategori')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('description')->label('Deskripsi Produk')->searchable(),
                Tables\Columns\TextColumn::make('price')->label('Harga')->money('IDR')->sortable(),
                Tables\Columns\TextColumn::make('stock_quantity')->label('Stok')->sortable(),
                Tables\Columns\ToggleColumn::make('is_active')
                ->label('Aktif'),

                Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->dateTime('d M Y H:i')->sortable(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
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
