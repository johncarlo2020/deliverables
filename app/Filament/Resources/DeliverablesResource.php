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
use Filament\Tables\Filters\SelectFilter;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Illuminate\Support\Facades\Auth;
class DeliverablesResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Deliverables::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'deliverables';

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'download',
            'accept',
            'reject'
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->user()->id)
                    ->disabled(),
                Forms\Components\FileUpload::make('file')->required(),
                Forms\Components\Select::make('deliverables_category_id')
                            ->label('Category')
                            ->options(DeliverablesCategory::whereIn('id',function($query){
                                $query->select('deliverables_category_id')
                                    ->from('user_categories')
                                    ->where('user_id',auth()->user()->id);
                            })->whereDoesntHave('deliverables', function ($query2) {
                                $query2->where('user_id', auth()->user()->id );
                            })->pluck('name','id'))
                            ->required(),
                Forms\Components\TextInput::make('description')->columnSpan('full')->required(),
                Forms\Components\Fieldset::make('School')
                            ->schema([
                                Forms\Components\Select::make('semester_id')
                                    ->label('Semester')
                                    ->options(Semester::all()->pluck('name', 'id'))
                                    ->searchable()->required(),
                            Forms\Components\Select::make('school_year_id')
                                    ->label('School Year')
                                    ->options(SchoolYear::all()->pluck('name', 'id'))
                                    ->searchable()->required(),
                            ])
                            ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('category.name')->searchable(),
                Tables\Columns\TextColumn::make('description')->searchable(),
                Tables\Columns\BadgeColumn::make('created_at')
                ->label('Submisssion')
                ->color(function ($record) {
                    // dd($record->category->deadline)
                    if($record->created_at <= $record->category->deadline){
                        return 'success';
                    }else{
                        return 'danger';
                    }
                }
                ),
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
                SelectFilter::make('status')
                ->options([
                    '0' => 'Pending',
                    '1' => 'Approved',
                    '2' => 'Rejected',
                ])
                ->attribute('status')
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Action::make('download')
                    ->label('download')
                    ->icon('heroicon-s-arrow-down')
                    ->color('primary')
                    ->action(function ($record) {
                        if (Storage::disk('public')->exists($record->file)) {
                            return response()->download(public_path('storage/' . $record->file));
                        }
                    }),
                Tables\Actions\EditAction::make(),
                Action::make('Approve')
                    ->label('Approve')
                    ->icon('heroicon-s-check-circle')
                    ->color('success')
                    ->action(function ($record) {$record->update(['status' => '1']);})
                    ->requiresConfirmation()
                    ->visible(fn (Deliverables $record): bool => Auth::user()->hasRole('admin'))
                    ->modalHeading('Approve Deliverable')
                        ->modalSubheading('Are you sure want to approve this deliverable ?')
                        ->modalButton("Yes, I'm sure!"),
                Action::make('Reject')
                        ->label('Reject')
                        ->icon('heroicon-s-x-circle')
                        ->color('danger')
                        ->action(function ($record) {$record->update(['status' => '2']);})
                        ->requiresConfirmation()
                        ->visible(fn (Deliverables $record): bool => Auth::user()->hasRole('admin'))
                        ->modalHeading('Reject Deliverable')
                        ->modalSubheading('Are you sure want to reject this deliverable ?')
                        ->modalButton("Yes, I'm sure!"),
                Tables\Actions\DeleteAction::make(),
                ])
                

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
    
    public static function getEloquentQuery(): Builder 
    {
        $query = parent::getEloquentQuery();

        if (Auth::check() && Auth::user()->hasRole('admin')) {
            // The user has the admin role
        } else {
                $query->where('user_id', auth()->user()->id );
           
        }
        return $query;
    }

}
