<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Hidden;
use App\Models\Role;
use Illuminate\Validation\Rules\Unique;
use Filament\Forms\Components\Card;
use Filament\Schemas\Components\Section;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                
                Section::make('Información del alumno')
                    ->schema([
                        TextInput::make('dni')
                            ->label('DNI')
                            ->required()
                            ->unique(
                                table: 'users',
                                column: 'dni',
                                ignorable: fn ($record) => $record,
                                modifyRuleUsing: fn (Unique $rule) => $rule
                            )
                            ->validationAttribute('DNI')
                            ->validationMessages([
                                'unique' => 'DNI existente!',
                            ]),
                        TextInput::make('name')
                            ->label('name')
                            ->translateLabel()
                            ->required(),
                        TextInput::make('phone')
                            ->label('Phone number')
                            ->translateLabel()
                            ->tel(),
                        Toggle::make('active')
                            ->label('Is active')
                            ->visible(fn ($livewire) => $livewire instanceof EditStudent) 
                            ->default(true),
                    ])
                    ->columns(1),
                    Section::make('Información de acceso')
                    ->schema([
                        TextInput::make('email')
                            ->label('Email address')
                            ->translateLabel()
                            ->email()
                            ->required()
                            ->unique(
                                table: 'users',
                                column: 'email',
                                ignorable: fn ($record) => $record,
                                modifyRuleUsing: fn (Unique $rule) => $rule
                            )
                            ->validationAttribute('Email')
                            ->validationMessages([
                                'unique' => 'Email existente!',
                            ]),
                        TextInput::make('password')
                            ->label( 'Password')
                            ->translateLabel()
                            ->belowContent('Cambiar solo si desea actualizar la contraseña.')
                            ->password()
                            ->required(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                            ->dehydrated(fn ($state) => filled($state)),
            ])
                

    ]);
            
    }

}
