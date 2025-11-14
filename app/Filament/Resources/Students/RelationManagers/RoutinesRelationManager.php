<?php

namespace App\Filament\Resources\Students\RelationManagers;

use App\Filament\Resources\Routines\RoutineResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\DatePicker;  
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use App\Models\User; 

class RoutinesRelationManager extends RelationManager
{
    protected static string $relationship = 'routines';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student_id')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                CreateAction::make()
                 ->form([
                        // campos del formulario para crear una rutina
                        TextInput::make('name')
                            ->label('Título')
                            ->required(),

                        DatePicker::make('start_date')
                        ->required(),

                        DatePicker::make('end_date'),

                        RichEditor::make('description')
                            ->label('Descripción'),

                        // HIDDEN student_id autocompletado con el ownerRecord->id
                        Hidden::make('student_id')
                            ->default(fn ($livewire) => $livewire->ownerRecord->id)
                            ->dehydrated(true), // FORZAR que se envíe el campo aunque esté oculto
                    ]),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),

            ]);
    }

    public function form(Schema $schema): Schema
    {
        return \App\Filament\Resources\Routines\RoutineResource::form($schema);
    }
    
}
