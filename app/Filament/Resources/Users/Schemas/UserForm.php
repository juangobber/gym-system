<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use App\Models\Role;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información del usuario')
                ->schema([
                    TextInput::make('dni')
                        ->label('DNI'),
                    TextInput::make('name')
                        ->label('name')
                        ->translateLabel()
                        ->required(),
                    TextInput::make('phone')
                        ->label('Phone number')
                        ->translateLabel()
                        ->tel(),
                ]),
                Section::make('Información de acceso')
                    ->schema([
                        TextInput::make('email')
                        ->label('Email address')
                        ->translateLabel()
                        ->email()
                        ->required(),
                        TextInput::make('password')
                            ->label('Password')
                            ->translateLabel()
                            ->password()
                            ->required(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                            ->dehydrated(fn ($state) => filled($state)),
                        Select::make('role_id')
                            ->label('Rol')
                            ->translateLabel()
                            ->relationship('role', 'name') 
                            ->preload()
                            ->searchable()
                            ->required(),
                            Toggle::make('active')
                            ->label('Active')
                            ->translateLabel()
                            ->default(true)
                            ->required(),
                ])
            ]);
    }
}
