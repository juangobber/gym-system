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
use Filament\Actions\ActionGroup;

class RoutinesRelationManager extends RelationManager
{
    protected static string $relationship = 'routines';
    
    protected static ?string $title = 'Rutinas';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Título')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->translateLabel()
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('End Date')
                    ->translateLabel()
                    ->date()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Crear rutina')
                    ->form([
                            // campos del formulario para crear una rutina
                            TextInput::make('name')
                                ->label('Título')
                                ->required(),

                            DatePicker::make('start_date')
                            ->label('Start Date')
                             ->translateLabel()
                                ->default(now()->toDateString())
                            ->required(),

                            DatePicker::make('end_date')
                            ->label('End Date')
                             ->translateLabel(),

                            RichEditor::make('description')
                                ->label('Descripción')
                                ->extraAttributes(['style' => 'min-height: 400px;'])
,

                            // HIDDEN student_id autocompletado con el ownerRecord->id
                            Hidden::make('student_id')
                                ->default(fn ($livewire) => $livewire->ownerRecord->id)
                                ->dehydrated(true), // FORZAR que se envíe el campo aunque esté oculto
                        ]),
                ])
                ->actions([
                    ActionGroup::make([
                        ViewAction::make(),
                        EditAction::make(),
                        DeleteAction::make(),
                    ])
                    

            ]);
    }

    public function form(Schema $schema): Schema
    {
        return \App\Filament\Resources\Routines\RoutineResource::form($schema);
    }
    
}
