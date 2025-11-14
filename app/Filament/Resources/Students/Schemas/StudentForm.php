<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Hidden;
use App\Models\Role;
use Illuminate\Validation\Rules\Unique;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->required(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                    ->dehydrated(fn ($state) => filled($state)),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('medical_certificate'),
                Toggle::make('active')
                    ->label('Is active')
                    ->visible(fn ($livewire) => $livewire instanceof EditStudent) 
                    ->default(true),
            ]);
    }

}
