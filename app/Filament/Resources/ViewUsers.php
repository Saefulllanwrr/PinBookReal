<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\UsersResource;

class ViewUsers extends ViewRecord
{
    protected static string $resource = UsersResource::class;
}
