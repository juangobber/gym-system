<?php

namespace App\Filament\Resources\Payments\Payments\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;


class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('user_id')
                ->label('Estudiante')
                // 1) nombre de la relación en Payment + atributo de título
                ->relationship('user', 'name', function (Builder $query) {
                    // 2) filtro: solo alumnos (ajustá si tu mapeo no es 3)
                    $query->where('role_id', 3);
                    // O por nombre de rol (más robusto):
                    // $query->whereHas('role', fn (Builder $r) => $r->where('name', 'student'));
                })
                ->searchable()
                ->preload()
                ->placeholder('Seleccionar estudiante')
                ->getOptionLabelFromRecordUsing(fn (?User $r) => $r ? "{$r->name} — {$r->email}" : '')
                ->required(),

            DatePicker::make('paid_at')
                ->label('Fecha de pago')
                ->required(),
        ]);
    }
}
