<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Peminjaman;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PeminjamanResource\Pages;

class PeminjamanResource extends Resource
{
    protected static ?string $model = Peminjaman::class;
    protected static ?string $navigationIcon = 'heroicon-o-document';
    protected static ?string $navigationLabel = 'Laporan Peminjaman';

    public static function canCreate(): bool
    {
        return false;
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('Nama Peminjam')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->disabled(),
                Select::make('buku_id')
                    ->label('Buku')
                    ->relationship('book', 'judul')
                    ->searchable()
                    ->disabled(),
                DatePicker::make('tanggal_pinjam')
                    ->label('Tanggal Pinjam')
                    ->disabled(),
                DatePicker::make('tanggal_kembali')
                    ->label('Tanggal Kembali')
                    ->disabled(),
                Select::make('status')
                    ->options([
                        'dipinjam' => 'Dipinjam',
                        'dikembalikan' => 'Dikembalikan',
                    ])
                    ->disabled(),
            ]);
    }
    // Gunakan TextColumn untuk mengatur warna

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama Peminjam')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('book.judul')
                    ->label('Judul Buku')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('tanggal_pinjam')
                    ->label('Tanggal Pinjam')
                    ->sortable(),
                TextColumn::make('tanggal_kembali')
                    ->label('Tanggal Kembali')
                    ->sortable(),
                // Ganti BadgeColumn dengan TextColumn dan set warna
                TextColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'dipinjam',
                        'success' => 'dikembalikan',
                    ])
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'dipinjam' => 'Dipinjam',
                        'dikembalikan' => 'Dikembalikan',
                    ]),
                Filter::make('tanggal_pinjam')
                    ->form([
                        Forms\Components\DatePicker::make('tanggal_pinjam'),
                    ])
                    ->query(
                        fn(Builder $query, array $data): Builder =>
                        isset($data['tanggal_pinjam'])
                            ? $query->whereDate('tanggal_pinjam', $data['tanggal_pinjam'])
                            : $query
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }




    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPeminjamen::route('/'),
        ];
    }
}
