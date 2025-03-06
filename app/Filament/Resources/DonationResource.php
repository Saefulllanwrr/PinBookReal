<?php

namespace App\Filament\Resources;

use App\Models\Donation;

use Filament\Tables\Table;
use Filament\Resources\Resource;

use Filament\Tables\Columns\TextColumn;

use Filament\Tables\Filters\SelectFilter;

use App\Filament\Resources\DonationResource\Pages;


class DonationResource extends Resource
{
    protected static ?string $model = Donation::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Laporan Donasi';
    protected static ?string $navigationGroup = 'Manajemen Laporan';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('order_id')->sortable()->searchable(),
            TextColumn::make('name')->sortable()->searchable(),
            TextColumn::make('email')->sortable(),
            TextColumn::make('amount')->money('IDR', true),
            TextColumn::make('payment_status')
                ->badge()
                ->colors([
                    'pending' => 'warning',
                    'success' => 'success',
                    'failed' => 'danger',
                    'expire' => 'gray',
                    'cancel' => 'gray',
                ]),
            TextColumn::make('created_at')->dateTime()->sortable(),
        ])->filters([
            SelectFilter::make('payment_status')
                ->options([
                    'pending' => 'Pending',
                    'success' => 'Success',
                    'failed' => 'Failed',
                    'expire' => 'Expired',
                    'cancel' => 'Canceled',
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
            'index' => Pages\ListDonations::route('/'),
            'create' => Pages\CreateDonation::route('/create'),
            'edit' => Pages\EditDonation::route('/{record}/edit'),
        ];
    }
}
