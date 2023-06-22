<?php

namespace App\Filament\Resources\DownloadablesResource\Pages;

use App\Filament\Resources\DownloadablesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDownloadables extends ListRecords
{
    protected static string $resource = DownloadablesResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
