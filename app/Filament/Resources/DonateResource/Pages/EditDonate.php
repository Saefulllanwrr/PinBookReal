<?php

namespace App\Filament\Resources\DonateResource\Pages;

use App\Filament\Resources\DonateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDonate extends EditRecord
{
    protected static string $resource = DonateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
