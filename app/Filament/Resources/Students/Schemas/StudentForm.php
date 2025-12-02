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
use Filament\Forms\Components\FileUpload;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                
                Section::make('Personal Information')
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
                            ->required(),
                        TextInput::make('phone')
                            ->tel(),
                        FileUpload::make('Medical certificate'),
                        Toggle::make('active')
                            ->label('Is active')
                            ->visible(fn ($livewire) => $livewire instanceof EditStudent) 
                            ->default(true),
                    ])
                    ->columns(1),
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
            ])
                

    ]);
            
    }

}
