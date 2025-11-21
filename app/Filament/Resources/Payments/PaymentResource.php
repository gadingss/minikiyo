<?php

namespace App\Filament\Resources\Payments;

use App\Filament\Resources\Payments\Pages;
use App\Models\Payment;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use BackedEnum;
use UnitEnum;


class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-credit-card';
    protected static UnitEnum|string|null $navigationGroup = 'Manajemen Toko';
    protected static ?string $navigationLabel = 'Payments';
    protected static ?string $pluralLabel = 'Payments';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
                Forms\Components\TextInput::make('order_id')->required(),
                Forms\Components\DateTimePicker::make('payment_date'),
                Forms\Components\TextInput::make('amount')->numeric()->required(),
                Forms\Components\TextInput::make('payment_method')->required(),
                Forms\Components\Select::make('payment_status')
                    ->options([
                        'unpaid'   => 'Unpaid',
                        'pending'  => 'Pending',
                        'paid'     => 'Paid',
                        'failed'   => 'Failed',
                        'refunded' => 'Refunded',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('transaction_reference'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('order_id')->label('Order ID'),
                Tables\Columns\TextColumn::make('payment_date')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('amount')->money('IDR', true),
                Tables\Columns\TextColumn::make('payment_method')->sortable(),
                Tables\Columns\BadgeColumn::make('payment_status')
                    ->colors([
                        'secondary' => 'unpaid',
                        'warning'   => 'pending',
                        'success'   => 'paid',
                        'danger'    => 'failed',
                        'info'      => 'refunded',
                    ]),
                Tables\Columns\TextColumn::make('transaction_reference')->label('Trans. Ref.'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([])
            // ->actions([
            //     Tables\Actions\ViewAction::make(),
            //     Tables\Actions\EditAction::make(),
            //     Tables\Actions\DeleteAction::make(),
            // ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
