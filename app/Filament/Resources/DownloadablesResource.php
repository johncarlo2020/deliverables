<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DownloadablesResource\Pages;
use App\Filament\Resources\DownloadablesResource\RelationManagers;
use App\Models\Downloadables;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Storage;

class DownloadablesResource extends Resource
{
    protected static ?string $model = Downloadables::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
                Forms\Components\FileUpload::make('file')->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
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
                Action::make('download')
                ->label('download')
                ->icon('heroicon-s-arrow-down')
                ->color('primary')
                ->action(function ($record) {
                    if (Storage::disk('public')->exists($record->file)) {
                        return response()->download(public_path('storage/' . $record->file));
                    }
                    }),
                
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
            'index' => Pages\ListDownloadables::route('/'),
            //'create' => Pages\CreateDownloadables::route('/create'),
            //'edit' => Pages\EditDownloadables::route('/{record}/edit'),
        ];
    }    
}
