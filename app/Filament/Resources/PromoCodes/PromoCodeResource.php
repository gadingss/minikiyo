<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromoCodeResource\Pages;
use App\Filament\Resources\PromoCodeResource\RelationManagers;
use App\Models\PromoCode;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use BackedEnum;
use UnitEnum;

class PromoCodeResource extends Resource
{
    protected static ?string $model = PromoCode::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-ticket';

    protected static UnitEnum|string|null $navigationGroup = 'Marketing';

    protected static ?string $navigationLabel = 'Promo Codes';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
                Forms\Components\Section::make('Informasi Promo Code')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50)
                            ->label('Kode Promo')
                            ->placeholder('DISKON10')
                            ->helperText('Kode unik yang akan dimasukkan customer')
                            ->columnSpan(1),

                        Forms\Components\Toggle::make('is_active')
                            ->default(true)
                            ->label('Aktif')
                            ->helperText('Nonaktifkan untuk menyembunyikan promo')
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Pengaturan Diskon')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->required()
                            ->options([
                                'percentage' => 'Persentase (%)',
                                'fixed' => 'Nominal Tetap (Rp)',
                            ])
                            ->default('percentage')
                            ->live()
                            ->label('Tipe Diskon'),

                        Forms\Components\TextInput::make('value')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->label('Nilai Diskon')
                            ->placeholder('10')
                            ->suffix(fn ($get) => $get('type') === 'percentage' ? '%' : 'IDR')
                            ->helperText(fn ($get) => $get('type') === 'percentage' 
                                ? 'Persentase diskon (contoh: 10 untuk 10%)'
                                : 'Jumlah diskon tetap (contoh: 5000 untuk Rp 5.000)'),

                        Forms\Components\TextInput::make('max_discount')
                            ->numeric()
                            ->minValue(0)
                            ->nullable()
                            ->label('Maksimal Diskon')
                            ->prefix('Rp')
                            ->helperText('Hanya untuk tipe persentase. Kosongkan untuk tidak ada batas.')
                            ->visible(fn ($get) => $get('type') === 'percentage'),

                        Forms\Components\TextInput::make('min_order')
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->label('Minimal Order')
                            ->prefix('Rp')
                            ->helperText('Minimum total order untuk menggunakan promo'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Batas Penggunaan')
                    ->schema([
                        Forms\Components\TextInput::make('usage_limit')
                            ->numeric()
                            ->minValue(1)
                            ->nullable()
                            ->label('Batas Penggunaan')
                            ->helperText('Kosongkan untuk unlimited usage'),

                        Forms\Components\TextInput::make('used_count')
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->disabled()
                            ->label('Sudah Digunakan')
                            ->helperText('Jumlah yang sudah digunakan'),

                        Forms\Components\DateTimePicker::make('valid_from')
                            ->nullable()
                            ->label('Berlaku Dari')
                            ->helperText('Kosongkan untuk langsung aktif'),

                        Forms\Components\DateTimePicker::make('valid_until')
                            ->required()
                            ->label('Berlaku Sampai')
                            ->minDate(now())
                            ->helperText('Tanggal kadaluarsa promo'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable()
                    ->label('KODE')
                    ->copyable()
                    ->copyMessage('Kode disalin!')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match($state) {
                        'percentage' => 'Persentase',
                        'fixed' => 'Fixed',
                    })
                    ->color(fn ($state) => match($state) {
                        'percentage' => 'info',
                        'fixed' => 'success',
                    })
                    ->label('TIPE'),

                Tables\Columns\TextColumn::make('value')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->type === 'percentage' 
                            ? "{$state}%" 
                            : "Rp " . number_format($state, 0, ',', '.');
                    })
                    ->label('NILAI DISKON'),

                Tables\Columns\TextColumn::make('max_discount')
                    ->formatStateUsing(fn ($state) => $state 
                        ? "Rp " . number_format($state, 0, ',', '.') 
                        : '-')
                    ->label('MAKS DISKON'),

                Tables\Columns\TextColumn::make('min_order')
                    ->formatStateUsing(fn ($state) => $state > 0 
                        ? "Rp " . number_format($state, 0, ',', '.') 
                        : 'Tidak ada')
                    ->label('MIN. ORDER'),

                Tables\Columns\TextColumn::make('usage')
                    ->label('PENGGUNAAN')
                    ->formatStateUsing(function ($record) {
                        if ($record->usage_limit) {
                            return "{$record->used_count}/{$record->usage_limit}";
                        }
                        return "{$record->used_count} (Unlimited)";
                    })
                    ->color(function ($record) {
                        if ($record->usage_limit && $record->used_count >= $record->usage_limit) {
                            return 'danger';
                        }
                        return 'success';
                    }),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('AKTIF')
                    ->sortable(),

                Tables\Columns\TextColumn::make('valid_until')
                    ->label('EXPIRED')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->color(fn ($record) => $record->valid_until->isPast() ? 'danger' : 'success')
                    ->description(fn ($record) => $record->valid_until->isPast() ? 'Expired' : 'Aktif'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('active')
                    ->label('Aktif Saja')
                    ->query(fn (Builder $query) => $query->where('is_active', true)),

                Tables\Filters\Filter::make('expired')
                    ->label('Sudah Expired')
                    ->query(fn (Builder $query) => $query->where('valid_until', '<', now())),

                Tables\Filters\Filter::make('available')
                    ->label('Masih Tersedia')
                    ->query(function (Builder $query) {
                        return $query->where('is_active', true)
                                    ->where('valid_until', '>', now())
                                    ->where(function ($query) {
                                        $query->whereNull('usage_limit')
                                              ->orWhereRaw('used_count < usage_limit');
                                    });
                    }),

                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'percentage' => 'Persentase',
                        'fixed' => 'Fixed Amount',
                    ])
                    ->label('Tipe Diskon'),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\Action::make('view_usage')
                    ->icon('heroicon-o-eye')
                    ->label('')
                    ->tooltip('Lihat Detail Penggunaan')
                    ->modalHeading('Detail Penggunaan Promo Code')
                    ->modalDescription(fn ($record) => "Kode: {$record->code}")
                    ->modalContent(function ($record) {
                        return view('filament.promo-code-usage', ['promoCode' => $record]);
                    })
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup'),

                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('duplicate')
                    ->icon('heroicon-o-document-duplicate')
                    ->label('')
                    ->tooltip('Duplicate Promo Code')
                    ->action(function (PromoCode $record) {
                        $newRecord = $record->replicate();
                        $newRecord->code = $record->code . '_COPY';
                        $newRecord->used_count = 0;
                        $newRecord->valid_from = now();
                        $newRecord->valid_until = now()->addMonth();
                        $newRecord->save();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Duplicate Promo Code')
                    ->modalDescription('Apakah Anda yakin ingin menduplikat promo code ini?')
                    ->modalSubmitActionLabel('Ya, Duplicate'),

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Belum ada promo code')
            ->emptyStateDescription('Buat promo code pertama Anda untuk menarik lebih banyak customer.')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Buat Promo Code')
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
            'index' => Pages\ListPromoCodes::route('/'),
            'create' => Pages\CreatePromoCode::route('/create'),
            'edit' => Pages\EditPromoCode::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_active', true)
            ->where('valid_until', '>', now())
            ->count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'success';
    }
}