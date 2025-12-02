<?php

namespace App\Filament\Resources\Routines\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;
use App\Models\User;
use App\Models\Routine;
use App\Models\Role;
use Filament\Schemas\Components\Section;

class RoutineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información de la rutina')                
                ->schema([
                    Select::make('student_id')
                        ->label('Student')
                        ->translateLabel()
                        ->relationship(
                            'student',
                            'name',
                            fn ($query) => $query->where(
                                'role_id',
                                Role::where('name', 'student')->value('id')
                            )
                        )
                        ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} - DNI: {$record->dni}")
                        ->placeholder('Seleccionar alumno')                     
                        ->disabled(function () {                             
                            $studentRoleId = Role::where('name', 'student')->value('id');
                            return User::where('role_id', $studentRoleId)->doesntExist();
                        })
                        ->searchable()
                        ->preload()
                        ->required(),

                    TextInput::make('name')->required()->label('Routine Name')->translateLabel(),
                    DatePicker::make('start_date')->required()->default(now()->toDateString())->label('Start Date')->translateLabel(),
                    DatePicker::make('end_date')->label('End Date')->translateLabel(    ),
                    RichEditor::make('description')
                        ->label('Descripción de la rutina')
                        ->belowLabel('Utilice este campo para detallar los objetivos y características de la rutina.')
                        ->columnSpanFull()
                        ->extraAttributes(['style' => 'min-height: 500px;']),                   
                ])
                ->columns(2)
                ->columnSpanFull(),              
            ]);
    }
}
