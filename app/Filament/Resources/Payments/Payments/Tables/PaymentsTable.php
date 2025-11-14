<?php

namespace App\Filament\Resources\Payments\Payments\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(
                Payment::query()
                    ->select('payments.*')
                    ->joinSub(
                        DB::table('payments')
                            ->selectRaw('user_id, MAX(paid_at) as latest_paid_at')
                            ->groupBy('user_id'),
                        'latest',
                        fn ($join) => $join
                            ->on('payments.user_id', '=', 'latest.user_id')
                            ->on('payments.paid_at', '=', 'latest.latest_paid_at')
                    )
                    ->with('user')
            )
            ->columns([
                TextColumn::make('user.name')->label('Nombre completo')->searchable(),
                TextColumn::make('user.email')->label('Correo')->searchable(),
                TextColumn::make('user.phone')->label('Teléfono')->searchable(),

                BadgeColumn::make('status')
                    ->label('Estado del pago')
                    ->state(function (Payment $record): string {
                        if (blank($record->paid_at)) {
                            return 'Vencido';
                        }
                        return Carbon::parse($record->paid_at)->lt(now()->subDays(30)) ? 'Vencido' : 'Al día';
                    })
                    ->colors([
                        'success' => fn (string $state) => $state === 'Al día',
                        'danger'  => fn (string $state) => $state === 'Vencido',
                    ]),

                TextColumn::make('paid_at')->label('Fecha de pago')->date('d/m/Y')->sortable(),
            ])
            ->defaultSort('paid_at', 'desc');
    }
}
