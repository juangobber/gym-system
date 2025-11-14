<?php

namespace App\Filament\Resources\Shifts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use App\Models\Shift;
use Illuminate\Database\Eloquent\Builder;

class ShiftForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('activity_id')
                    ->label('Actividad')
                    ->relationship('activity', 'name', function (Builder $query) {
                        $query->where('is_active', true);
                    })
                    ->searchable()
                    ->preload()
                    ->required()
                    // Evita seleccionar una actividad inactiva (o eliminada)
                    ->rules(function ($get) {
                        return [
                            function (string $attribute, $value, $fail) {
                                if (! $value) return;
                                $act = \App\Models\Activity::query()->find($value);
                                if (! $act || ! $act->is_active) {
                                    $fail('La actividad seleccionada no está activa.');
                                }
                            }
                        ];
                    }),

                Select::make('teacher_id')
                    ->label('Profesor')
                    ->relationship(
                        name: 'teacher',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn ($query) => $query->where('role_id', 2)
                    )
                    ->preload()
                    ->required()
                    ->searchable(),

                Select::make('day_of_week')
                    ->label('Día de la semana')
                    ->options([
                        'monday'    => 'Lunes',
                        'tuesday'   => 'Martes',
                        'wednesday' => 'Miércoles',
                        'thursday'  => 'Jueves',
                        'friday'    => 'Viernes',
                        'saturday'  => 'Sábado',
                        'sunday'    => 'Domingo',
                    ])
                    ->required(),

                Select::make('start_time')
                    ->label('Hora de inicio')
                    // Opciones cada 60 minutos desde 08:00 a 21:00 (con segundos para matchear en edición)
                    ->options(collect(range(8 * 60, 21 * 60, 60))->mapWithKeys(function ($minutes) {
                        $time = sprintf('%02d:%02d:00', floor($minutes / 60), $minutes % 60);
                        return [$time => $time];
                    }))
                    ->required(),

                Select::make('end_time')
                ->label('Hora de fin')
                // Opciones cada 60 minutos desde 08:00 a 21:00 (con segundos)
                ->options(collect(range(8 * 60, 21 * 60, 60))->mapWithKeys(function ($minutes) {
                    $time = sprintf('%02d:%02d:00', floor($minutes / 60), $minutes % 60);
                    return [$time => $time];
                }))
                ->required()
                // Validaciones: fin > inicio y no duplicar día+horario
                ->rules(function ($get) {
                    return [
                        function (string $attribute, $value, $fail) use ($get) {
                            $start = $get('start_time');
                            // 1) fin > inicio
                            if ($start && $value && strcmp($value, $start) <= 0) {
                                $fail('La hora de fin debe ser mayor que la hora de inicio.');
                                return;
                            }

                            // 2) no duplicar día + rango exacto
                            $day   = $get('day_of_week');
                            $start = $get('start_time');
                            $end   = $value;
                            if (! $day || ! $start || ! $end) {
                                return;
                            }

                            $currentId = request()->route('record');
                            $exists = Shift::query()
                                ->where('day_of_week', $day)
                                ->where('start_time', $start)
                                ->where('end_time', $end)
                                ->when($currentId, fn ($q) => $q->where('id', '!=', $currentId))
                                ->exists();

                            if ($exists) {
                                $fail('Ya existe un turno con ese día y horario.');
                            }
                        },
                    ];
                }),
            ]);
    }
}
