<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\Widgets\UserOverview;


class DeliverablesRelationManager extends RelationManager
{
    protected static string $relationship = 'Deliverables';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                 Tables\Columns\TextColumn::make('category.name'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\BadgeColumn::make('created_at')
                ->label('Submisssion Date')
                ->color(function ($record) {
                    // dd($record->category->deadline)
                    if($record->created_at <= $record->category->deadline){
                        return 'success';
                    }else{
                        return 'danger';
                    }
                }),
                 Tables\Columns\TextColumn::make('category.deadline')
                ->label('deadline'),
                Tables\Columns\TextColumn::make('status')->enum([
                    '0' => 'Draft',
                    '1' => 'Reviewing',
                    '2' => 'Published',
                ]),
               

                
                
                Tables\Columns\BadgeColumn::make('status')
                ->label('Status')
                ->color(function ($record) {
                    if($record->status == 'Pending'){
                        return 'pending';
                    }else if($record->status == 'Approved'){
                        return 'success';
                    }else{
                        return 'danger';
                    }
                }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
            ])
            ->actions([
            ])
            ->bulkActions([
            ]);
    }  
    
    public static function getWidgets(): array
    {
        return [
            UserOverview::class,
        ];
    }
}
