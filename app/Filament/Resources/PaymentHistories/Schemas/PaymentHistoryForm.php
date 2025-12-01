<?php

namespace App\Filament\Resources\PaymentHistories\Schemas;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class PaymentHistoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Alumno')
                    ->relationship('user', 'name', function (Builder $query) {
                        $query->where('role_id', 3);
                    })
                    ->searchable()
                    ->preload()
                    ->required(),

                DatePicker::make('paid_at')
                    ->label('Fecha de pago')
                    ->maxDate(now())
                    ->required(),
            ]);
    }
}
