<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $countBook = Book::count();
        return [
            Stat::make('Total Buku', $countBook . ' Buku'),
            Stat::make('Buku di Pinjam', '...'),
            Stat::make('Average time on page', '3:12'),
        ];
    }
}
