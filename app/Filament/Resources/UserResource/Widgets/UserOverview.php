<?php

namespace App\Filament\Resources\UserResource\Widgets;

use Illuminate\Database\Eloquent\Model;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Deliverables;


class UserOverview extends BaseWidget
{
  public $record;

    protected function getCards(): array
    {
        $late = Deliverables::join('deliverables_categories', 'deliverables.deliverables_category_id', '=', 'deliverables_categories.id')
        ->whereRaw('deliverables.created_at >= deliverables_categories.deadline')->where('user_id',$this->record->id)
        ->count();

        $onTime = Deliverables::join('deliverables_categories', 'deliverables.deliverables_category_id', '=', 'deliverables_categories.id')
        ->whereRaw('deliverables.created_at <= deliverables_categories.deadline')->where('user_id',$this->record->id)
        ->count();
        return [
            Card::make('Submitted Deliverables', Deliverables::where('user_id',$this->record->id)->count())
            ->color('success'),
            Card::make('Late Submission', $late)->color('danger'),
            Card::make('On Time', $onTime),
        ];
    }

}
