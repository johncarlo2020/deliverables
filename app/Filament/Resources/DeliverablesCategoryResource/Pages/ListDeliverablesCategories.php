<?php

namespace App\Filament\Resources\DeliverablesCategoryResource\Pages;

use App\Filament\Resources\DeliverablesCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeliverablesCategories extends ListRecords
{
    protected static string $resource = DeliverablesCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
