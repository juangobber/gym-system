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
                Section::make('Routine Information')                
                ->schema([
                    Select::make('student_id')
                        ->label('Student')
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

                    TextInput::make('name')->required()->label('Routine Name'),
                    DatePicker::make('start_date')->required()->default(now()->toDateString()),
                    DatePicker::make('end_date'),
                    RichEditor::make('description')
                        ->label('Descripción')
                        ->belowLabel('Use this area to provide detailed information about the routine.')
                        ->columnSpanFull()
                        ->extraAttributes(['style' => 'min-height: 500px;']),                   
                ])
                ->columns(2)
                ->columnSpanFull(),              
            ]);
    }
}
