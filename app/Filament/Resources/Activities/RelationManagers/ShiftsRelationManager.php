<?php

namespace App\Filament\Resources\Activities\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;

class ShiftsRelationManager extends RelationManager
{
    protected static string $relationship = 'shifts';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('activity_id')
                    ->label('Actividad')
                    ->relationship('activity', 'name')
                    ->required(),

                Select::make('teacher_id')
                    ->label('Profesor')
                    ->relationship(
                        name: 'teacher',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn ($query) => $query->where('role_id', 2)
                    )
                    ->preload()
                    ->required()
                    ->searchable(),

                Select::make('day_of_week')
                    ->label('Día de la semana')
                    ->options([
                        'monday'    => 'Lunes',
                        'tuesday'   => 'Martes',
                        'wednesday' => 'Miércoles',
                        'thursday'  => 'Jueves',
                        'friday'    => 'Viernes',
                        'saturday'  => 'Sábado',
                        'sunday'    => 'Domingo',
                    ])
                    ->required(),

                Select::make('start_time')
                    ->label('Hora de inicio')
                    ->options(collect(range(8 * 60, 21 * 60, 15))->mapWithKeys(function ($minutes) {
                        $time = sprintf('%02d:%02d', floor($minutes / 60), $minutes % 60);
                        return [$time => $time];
                    }))
                    ->required(),

                Select::make('end_time')
                ->label('Hora de fin')
                ->options(collect(range(8 * 60, 21 * 60, 15))->mapWithKeys(function ($minutes) {
                    $time = sprintf('%02d:%02d', floor($minutes / 60), $minutes % 60);
                    return [$time => $time];
                }))
                ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('start_time')
            ->columns([
                TextColumn::make('teacher.Name')
                    ->label('Teacher name')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(function ($record) {
                        // Solo muestra si el user tiene rol "teacher"
                        if ($record->teacher && $record->teacher->role && $record->teacher->role->name === 'teacher') {
                            return $record->teacher->name;
                        }
                        return '—'; // guion si no tiene profe asignado o no es docente
                    }),
                TextColumn::make('day_of_week')
                    ->searchable(),
                TextColumn::make('start_time')
                    ->time()
                    ->sortable(),
                TextColumn::make('end_time')
                    ->time()
                    ->sortable(),
                TextColumn::make('capacity')
                    ->numeric()
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
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                // Se elimina el botón "Associate" para no asociar existentes
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
