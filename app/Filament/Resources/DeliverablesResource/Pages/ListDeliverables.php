<?php

namespace App\Filament\Resources\DeliverablesResource\Pages;

use App\Filament\Resources\DeliverablesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeliverables extends ListRecords
{
    protected static string $resource = DeliverablesResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
