<?php

namespace App\Filament\Resources\DownloadablesResource\Pages;

use App\Filament\Resources\DownloadablesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDownloadables extends EditRecord
{
    protected static string $resource = DownloadablesResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
