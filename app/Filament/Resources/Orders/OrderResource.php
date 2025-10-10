<?php

namespace App\Filament\Resources\Orders;

use App\Filament\Resources\Orders\Pages;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use UnitEnum;
use BackedEnum;
use App\Helpers\Fonnte;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;

// FILAMENT v4 pakai ini:
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\Action;
// tambahkan ini
use Filament\Actions\DeleteBulkAction;


class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-shopping-cart';
    protected static UnitEnum|string|null $navigationGroup = 'Manajemen Toko';
    protected static ?string $navigationLabel = 'Orders';
    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\Select::make('user_id')
                ->label('Customer')
                ->relationship('user', 'full_name')
                ->searchable()
                ->required(),

            Forms\Components\DateTimePicker::make('order_date')
                ->label('Tanggal Order')
                ->default(now())
                ->required()
                ->dehydrated(true),


            Forms\Components\TextInput::make('total_amount')
                ->label('Total Amount')
                ->numeric()
                ->required(),

            Forms\Components\Textarea::make('shipping_address')
                ->label('Alamat Pengiriman'),

            Repeater::make('items')
                ->relationship('items') // relasi ke order_items
                ->schema([
                    Select::make('product_id')
                        ->relationship('product', 'name')
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                            $product = \App\Models\Product::find($state);
                            if ($product) {
                                $set('unit_price', $product->price);

                                // hitung ulang total
                                self::calculateTotal($set, $get);
                            }
                        }),

                    TextInput::make('quantity')
                        ->numeric()
                        ->default(1)
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                            // hitung ulang total
                            self::calculateTotal($set, $get);
                        }),

                    TextInput::make('unit_price')
                        ->numeric()
                        ->disabled() // biar user nggak edit manual
                        ->dehydrated(), // tetap ikut tersimpan
                ])
                ->columns(3)
                ->createItemButtonLabel('Tambah Produk')
                ->live()
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    self::calculateTotal($set, $get);
                }),



            Forms\Components\TextInput::make('tracking_number')
                ->label('No. Resi')
                ->disabled() // biar admin gak bisa ngubah manual
                ->dehydrated(false) // biar gak dikirim dari form, cukup dari model event
                ->default(fn () => null),

            // ENUM status sesuai DB
            Forms\Components\Select::make('status')
                ->options([
                    'pending'    => 'Pending',
                    'processing' => 'Processing',
                    'ready'      => 'Ready',
                    'shipped'    => 'Shipped',
                    'completed'  => 'Completed',
                    'cancelled'  => 'Cancelled',
                ])
                ->default('pending'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('user.full_name')->label('Customer'),
            Tables\Columns\TextColumn::make('user.phone')
                ->label('No. HP'),
            Tables\Columns\ViewColumn::make('items')
                ->label('Produk')
                ->view('filament.tables.columns.order-products'),
            Tables\Columns\TextColumn::make('total_amount')->label('Total')->money('IDR'),
            Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'danger'  => 'cancelled',
                    'warning' => 'processing',
                    'info'    => 'ready',
                    'primary' => 'shipped',
                    'success' => 'completed',
                ]),
            Tables\Columns\TextColumn::make('order_date')->label('Tanggal')->dateTime('d M Y H:i'),
        ])
        ->filters([])
        ->recordActions([
            EditAction::make(),
            DeleteAction::make(),

            // Custom action: tandai sebagai selesai
            Action::make('selesaikan')
                ->label('Selesaikan')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn (Order $record) => $record->status !== 'completed') // hanya muncul kalau belum selesai
                ->action(function (Order $record) {
                    $record->update(['status' => 'completed']);

                    $user = $record->user;
                    $name = $user?->full_name ?? 'Pelanggan';
                    $phone = $user?->phone;
                    $total = $record->total_amount ?? 0;

                    $items = $record->items;

                    $itemList = "";
                    foreach ($items as $item) {
                        $namaProduk = $item->product->name ?? 'Produk';
                        $qty = $item->quantity;
                        $subtotal = number_format($item->subtotal, 0, ',', '.');
                        $itemList .= "- {$namaProduk} ({$qty}x) = Rp {$subtotal}\n";
                    }

                    $message = "✅ Halo {$name},\n"
                            . "Pesanan #{$record->id} sudah *selesai*.\n"
                            . "🛍️ *Detail Pesanan:*\n{$itemList}\n"
                            . "💰 *Total:* Rp " . number_format($total, 0, ',', '.') . "\n\n"
                            . "Terima kasih telah berbelanja di *Minikiyo Wonton!* 🙏";

                    if ($phone) {
                        \App\Helpers\Fonnte::sendMessage($phone, $message);
                    }
                }),

        ])
        ->toolbarActions([
            DeleteBulkAction::make(),
        ]);
    }

    protected static function calculateTotal(callable $set, callable $get): void
    {
        $items = $get('items') ?? [];
        $total = 0;

        foreach ($items as $item) {
            $qty   = (int) ($item['quantity'] ?? 0);
            $price = (int) ($item['unit_price'] ?? 0);
            $total += $qty * $price;
        }

        $set('total_amount', $total);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->with(['items.product']);
    }



    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
