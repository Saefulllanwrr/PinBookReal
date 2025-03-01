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
        $availableBooks = Book::where('status', 'available')->count(); // Menggunakan status yang benar

        return [
            'labels' => ['Total Buku', 'Dipinjam', 'Tersedia'],
            'datasets' => [
                [
                    'label' => 'Jumlah Buku',
                    'data' => [$totalBooks, $borrowedBooks, $availableBooks],
                    'backgroundColor' => ['#36A2EB', '#FF6384', '#4CAF50'],
                ],
            ],
        ];
    }
}
