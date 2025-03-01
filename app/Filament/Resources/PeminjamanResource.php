<?php

namespace App\Filament\Resources;

use App\Models\Book;
use App\Models\Peminjaman;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\PeminjamanResource\Pages;

class PeminjamanResource extends Resource
{
    protected static ?string $model = Peminjaman::class;
    protected static ?string $navigationIcon = 'heroicon-o-document';
    protected static ?string $navigationLabel = 'Laporan Peminjaman';
    protected static ?string $navigationGroup = 'Manajemen Laporan';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
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
                    'menunggu' => 'Menunggu',
                    'ditolak' => 'Ditolak',
                    'dipinjam' => 'Dipinjam',
                    'dikembalikan' => 'Dikembalikan',
                    'terlambat' => 'Terlambat',
                ])
                ->disabled(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('user.name')->label('Nama Peminjam')->sortable()->searchable(),
            TextColumn::make('book.judul')->label('Judul Buku')->sortable()->searchable(),
            TextColumn::make('tanggal_pinjam')->label('Tanggal Pinjam')->sortable(),
            TextColumn::make('tanggal_kembali')->label('Tanggal Kembali')->sortable(),
            TextColumn::make('status')
                ->label('Status')
                ->colors([
                    'info' => 'menunggu',
                    'danger' => 'ditolak',
                    'warning' => 'dipinjam',
                    'success' => 'dikembalikan',
                    'orange' => 'terlambat',
                ])
                ->searchable(),
        ])->actions([
            self::kembalikanAction(),
            self::setujuiAction(),
            self::tolakAction(),
            Tables\Actions\ViewAction::make(),
        ])->bulkActions([
            ExportBulkAction::make()->label('Export Data'),
        ]);
    }

    private static function kembalikanAction(): Action
    {
        return Action::make('kembalikan')
            ->label('Kembalikan')
            ->color('success')
            ->requiresConfirmation()
            ->action(function (Peminjaman $record) {
                if ($record->status !== 'dipinjam') {
                    return Notification::make()
                        ->title('Peminjaman tidak dapat dikembalikan!')
                        ->danger()
                        ->send();
                }

                DB::transaction(function () use ($record) {
                    $record->update(['status' => 'dikembalikan', 'tanggal_kembali' => now()]);
                    $record->book?->increment('stok');
                });

                return Notification::make()
                    ->title('Buku berhasil dikembalikan!')
                    ->success()
                    ->send();
            });
    }

    private static function setujuiAction(): Action
    {
        return Action::make('setujui')
            ->label('Setujui')
            ->color('primary')
            ->requiresConfirmation()
            ->action(function (Peminjaman $record) {
                if ($record->status !== 'menunggu') {
                    return Notification::make()
                        ->title('Peminjaman tidak dapat disetujui!')
                        ->danger()
                        ->send();
                }

                DB::transaction(function () use ($record) {
                    $record->update(['status' => 'dipinjam']);
                    $record->book->decrement('stok');
                });

                return Notification::make()
                    ->title('Peminjaman disetujui!')
                    ->success()
                    ->send();
            });
    }

    private static function tolakAction(): Action
    {
        return Action::make('tolak')
            ->label('Tolak')
            ->color('danger')
            ->requiresConfirmation()
            ->action(function (Peminjaman $record) {
                if ($record->status !== 'menunggu') {
                    return;
                }

                DB::transaction(function () use ($record) {
                    $record->delete();
                });

                return Notification::make()
                    ->title('Peminjaman ditolak dan dihapus!')
                    ->danger()
                    ->send();
            });
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPeminjamen::route('/'),
        ];
    }
}
