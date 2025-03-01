<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use App\Models\Peminjaman;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Total Buku
        $countBook = Book::count();

        // Buku yang sedang dipinjam
        $borrowedBooks = Peminjaman::where('status', 'dipinjam')->count(); // Menggunakan status yang benar
        $availableBooks = Book::where('status', 'available')->count();

        return [
            Stat::make('Total Buku', "{$countBook} Buku")
                ->description('Semua koleksi buku')
                ->icon('heroicon-o-book-open')
                ->color('primary'),

            Stat::make('Buku Dipinjam', "{$borrowedBooks} Buku")
                ->description('Sedang dipinjam')
                ->icon('heroicon-o-clipboard-document-check') // Ganti dengan yang tersedia
                ->color('warning'),

            Stat::make('Buku Tersedia', "{$availableBooks} Buku")
                ->description('Masih tersedia')
                ->icon('heroicon-o-check-circle')
                ->color('success'),
        ];
    }
}
