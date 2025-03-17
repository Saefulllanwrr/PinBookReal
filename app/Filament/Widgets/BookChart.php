<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use App\Models\Peminjaman;
use Filament\Widgets\ChartWidget;

class BookChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Peminjaman';
    protected static ?int $sort = 3; // Urutan widget

    protected function getType(): string
    {
        return 'line';    // Bisa diganti dengan 'line', 'pie', dll.
    }

    protected function getData(): array
    {
        $totalBooks = Book::count();
        $borrowedBooks = Peminjaman::where('status', 'dipinjam')->count(); // Menggunakan status yang benar
        $activeBorrowers = Peminjaman::where('status', 'dipinjam')
            ->distinct('user_id') // Hitung user yang unik
            ->count('user_id'); // Menggunakan status yang benar

        return [
            'labels' => ['Total Buku', 'Dipinjam', 'Peminjam'],
            'datasets' => [
                [
                    'label' => 'Statistik Peminjaman',
                    'data' => [$totalBooks, $borrowedBooks, $activeBorrowers],
                    'backgroundColor' => ['#36A2EB', '#FF6384', '#4CAF50'],
                ],
            ],
        ];
    }
}
