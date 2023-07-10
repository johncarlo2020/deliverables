<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\UserResource\Widgets\UserOverview;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getFooterWidgets(): array
    {
        return [
            UserOverview::class,
        ];
    }
}
