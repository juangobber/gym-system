<?php

namespace App\Filament\Resources\PaymentHistories\Tables;

use App\Models\Payment;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;

class PaymentHistoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(
                Payment::query()
                    ->with('user')
                    ->orderByDesc('paid_at')
            )
            ->columns([
                TextColumn::make('user.name')
                    ->label('Alumno')
                    ->searchable(),
                TextColumn::make('user.email')
                    ->label('Correo')
                    ->searchable(),
                TextColumn::make('paid_at')
                    ->label('Fecha de pago')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('user_id')
                    ->label('Alumno')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),

                Filter::make('paid_at')
                    ->form([
                        DatePicker::make('from')->label('Desde'),
                        DatePicker::make('until')->label('Hasta'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'] ?? null, fn ($q) => $q->whereDate('paid_at', '>=', $data['from']))
                            ->when($data['until'] ?? null, fn ($q) => $q->whereDate('paid_at', '<=', $data['until']));
                    }),
            ])
            ->recordActions([
            ])
            ->toolbarActions([
            ]);
    }
}
