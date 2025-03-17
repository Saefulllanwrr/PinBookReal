<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use App\Models\Peminjaman;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Total Buku
        $totalBooks = Book::count();

        // Buku yang sedang dipinjam
        $borrowedBooks = Peminjaman::where('status', 'dipinjam')->count();

        // Jumlah Peminjam (user yang sedang meminjam buku)
        $activeBorrowers = Peminjaman::where('status', 'dipinjam')
            ->distinct('user_id') // Hitung user yang unik
            ->count('user_id');

        return [
            Stat::make('Total Buku', "{$totalBooks} Buku")
                ->description('Semua koleksi buku')
                ->icon('heroicon-o-book-open')
                ->color('primary'),

            Stat::make('Buku Dipinjam', "{$borrowedBooks} Buku")
                ->description('Sedang dipinjam')
                ->icon('heroicon-o-clipboard-document-check')
                ->color('warning'),

            Stat::make('Jumlah Peminjam', "{$activeBorrowers} Peminjam")
                ->description('Sedang meminjam buku')
                ->icon('heroicon-o-users')
                ->color('success'),
        ];
    }
}
