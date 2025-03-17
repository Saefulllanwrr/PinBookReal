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
            ExportAction::make()
                ->modalHeading('Konfirmasi Ekspor Data')
                ->modalDescription('Apakah Anda yakin ingin mengekspor data ini?')
                ->requiresConfirmation()
                ->exports([
                    ExcelExport::make()->withColumns([
                        Column::make('isbn')->heading('ISBN')->format(NumberFormat::FORMAT_NUMBER),
                        Column::make('judul')->heading('Judul Buku'),
                        Column::make('penulis')->heading('Penulis'),
                        Column::make('penerbit')->heading('Penerbit'),
                        Column::make('diterbitkan')->heading('Tanggal Terbit'),
                        Column::make('kategori.nama_kategori')->heading('Kategori'),
                        Column::make('stok')->heading('Stok'),
                    ]),
                ]),
        ];
    }
}
