<?php

namespace App\Filament\Resources\Teachers\Schemas;

use App\Filament\Resources\Teachers\Pages\EditTeacher;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Hidden;
use App\Models\Role;
use Filament\Schemas\Components\Section;

class TeacherForm
{
    public static function configure(Schema $schema): Schema
    {
        $teacherRoleId = Role::where('name', 'teacher')->value('id');

        return $schema
            ->components([
                Section::make('Teacher Information')
                    ->schema([
                        TextInput::make('dni')
                        ->label('DNI'),
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('phone')
                        ->tel(),
                    ]),
                Section::make('Account Information')
            ->schema([
                    TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->required(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                    ->dehydrated(fn ($state) => filled($state)),
                Toggle::make('active')
                    ->label('Is active')
                    ->visible(fn ($livewire) => $livewire instanceof EditTeacher) 
                    ->default(true),
            ])
                
                
        ]);
    }
}
