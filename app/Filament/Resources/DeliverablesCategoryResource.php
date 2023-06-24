<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliverablesCategoryResource\Pages;
use App\Filament\Resources\DeliverablesCategoryResource\RelationManagers;
use App\Models\DeliverablesCategory;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeliverablesCategoryResource extends Resource
{
    protected static ?string $model = DeliverablesCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'deliverables';
    protected static ?string $navigationLabel = 'Categories';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\UserRelationManager::class,
            
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeliverablesCategories::route('/'),
            //'create' => Pages\CreateDeliverablesCategory::route('/create'),
            'edit' => Pages\EditDeliverablesCategory::route('/{record}/edit'),
        ];
    }    
}
