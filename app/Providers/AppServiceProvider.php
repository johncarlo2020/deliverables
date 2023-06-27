<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Filament::registerNavigationGroups(
           [
            'deliverables','setup','Schedules','filament shield', 'settings'

           ] 
           );

           Filament::serving(function () {
            Filament::registerNavigationItems([
                NavigationItem::make('Messages')
                    ->url('http://154.41.251.234//deliverables/public/chatify', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-presentation-chart-line')
                    ->activeIcon('heroicon-s-presentation-chart-line')
                    ->sort(3),
            ]);
        });
    }
}
