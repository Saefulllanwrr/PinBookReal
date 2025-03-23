<?php

namespace App\Filament\Resources\BooksResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use App\Filament\Resources\BooksResource;
use Filament\Resources\Pages\ListRecords;

class ListBooks extends ListRecords
{
    protected static string $resource = BooksResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('pdf')
                ->label('PDF')
                ->color('success')
                ->icon('heroicon-o-document-text')
                ->url(route('pdf', ['book' => 'all'])) // Sesuaikan route dengan kebutuhan
                ->openUrlInNewTab(),
        ];
    }
}
