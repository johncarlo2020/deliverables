<?php

namespace App\Filament\Resources\DeliverablesCategoryResource\Pages;

use App\Filament\Resources\DeliverablesCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDeliverablesCategory extends EditRecord
{
    protected static string $resource = DeliverablesCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
