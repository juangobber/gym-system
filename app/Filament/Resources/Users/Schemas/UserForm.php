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
                Section::make('User Information')
                ->schema([
                    TextInput::make('dni'),
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
                        Select::make('role_id')
                            ->relationship('role', 'name') 
                            ->preload()
                            ->searchable()
                            ->required(),
                            Toggle::make('active')
                            ->default(true)
                            ->required(),
                ])
            ]);
    }
}
