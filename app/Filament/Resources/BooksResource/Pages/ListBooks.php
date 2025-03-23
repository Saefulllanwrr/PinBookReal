<?php

namespace App\Filament\Resources\BooksResource\Pages;

use Filament\Actions;
use pxlrbt\FilamentExcel\Columns\Column;
use App\Filament\Resources\BooksResource;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListBooks extends ListRecords
{
    protected static string $resource = BooksResource::class;

    // **Tombol di Header (Atas Tabel)**
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
