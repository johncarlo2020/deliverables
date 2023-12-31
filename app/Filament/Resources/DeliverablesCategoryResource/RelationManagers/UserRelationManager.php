<?php

namespace App\Filament\Resources\DeliverablesCategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Component as Livewire;

class UserRelationManager extends RelationManager
{
    protected static string $relationship = 'Assign';

    protected static ?string $recordTitleAttribute = 'deliverables_categories_id';
    // protected static ?string $recordLabel = 'deliverablegories_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Faculty')
                    ->options(function (callable $get, Livewire $livewire){
                     
                                        return User::whereNotIn('id',function($query) use ($livewire) {
                                            $query->select('user_id')
                                                    ->from('user_categories')
                                                    ->where('deliverables_category_id',$livewire->ownerRecord->id);
                                        })->pluck('name','id');
                               
                        })
                    // ->options(User::whereIn('id',function($query, Livewire $livewire) {
                    //     $query->select('user_id')
                    //         ->from('user_categories')
                    //         ->where('deliverables_category_id',$livewire->ownerRecord->id);
                    // })->pluck('name','id'))
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name'),

            ])
            ->filters([
                
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
