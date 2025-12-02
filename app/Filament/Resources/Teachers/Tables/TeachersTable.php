<?php

namespace App\Filament\Resources\Teachers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;


class TeachersTable
{
    public static function configure(Table $table): Table
    {
       return $table
            ->columns([
                TextColumn::make('dni')
                    ->label('DNI')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('name')
                    ->translateLabel()
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->translateLabel()
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Phone number')
                    ->translateLabel()
                    ->searchable(),
                IconColumn::make('active')
                    ->label('Active')
                    ->translateLabel()
                    ->boolean(),
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
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
