<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use Filament\Widgets\ChartWidget;

class BookChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Buku';
    protected static ?int $sort = 2; // Urutan widget

    protected function getType(): string
    {
        return 'bar'; // Bisa diganti dengan 'line', 'pie', dll.
    }

    protected function getData(): array
    {
        $totalBooks = Book::count();
        $borrowedBooks = Book::where('status', 'dipinjam')->count();
        $availableBooks = Book::where('status', 'tersedia')->count();

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
