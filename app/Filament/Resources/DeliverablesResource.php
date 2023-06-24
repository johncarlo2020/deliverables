<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliverablesResource\Pages;
use App\Filament\Resources\DeliverablesResource\RelationManagers;
use App\Models\Deliverables;
use App\Models\Semester;
use App\Models\SchoolYear;
use App\Models\DeliverablesCategory;
use Livewire\Component as Livewire;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Storage;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeliverablesResource extends Resource
{
    protected static ?string $model = Deliverables::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'deliverables';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->user()->id)
                    ->disabled(),
                Forms\Components\FileUpload::make('file'),
                Forms\Components\Select::make('deliverables_category_id')
                            ->label('Category')
                            ->options(DeliverablesCategory::whereIn('id',function($query) {
                                $query->select('deliverables_category_id')
                                    ->from('user_categories')
                                    ->where('user_id',auth()->user()->id);
                            })->pluck('name','id')),
                Forms\Components\TextInput::make('description')->columnSpan('full'),
                
                Forms\Components\Fieldset::make('School')
                            ->schema([
                                Forms\Components\Select::make('semester_id')
                                    ->label('Semester')
                                    ->options(Semester::all()->pluck('name', 'id'))
                                    ->searchable(),
                            Forms\Components\Select::make('school_year_id')
                                    ->label('School Year')
                                    ->options(SchoolYear::all()->pluck('name', 'id'))
                                    ->searchable(),
                            ])
                            ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('category.name'),
                Tables\Columns\TextColumn::make('description')


            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('Turned_out')
                    ->label('Download')
                    ->color('secondary')
                    ->action(function ($record) {
                        if (Storage::disk('public')->exists($record->file)) {
                            return response()->download(public_path('storage/' . $record->file));
                        }
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeliverables::route('/'),
            //'create' => Pages\CreateDeliverables::route('/create'),
            //'edit' => Pages\EditDeliverables::route('/{record}/edit'),
        ];
    }    
}
