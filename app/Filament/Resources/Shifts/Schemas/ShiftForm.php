<?php

namespace App\Filament\Resources\Shifts\Schemas;

use App\Models\Shift;
use App\Models\Activity;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class ShiftForm
{
    public static function configure(Schema $schema): Schema
    {
        $timeOptions = collect(range(8 * 60, 21 * 60, 60))->mapWithKeys(function ($minutes) {
            $time = sprintf('%02d:%02d:00', floor($minutes / 60), $minutes % 60);
            return [$time => $time];
        })->all();

        return $schema
            ->components([
                Select::make('activity_id')
                    ->label('Actividad')
                    ->relationship('activity', 'name', function (Builder $query) {
                        $query->where('is_active', true);
                    })
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $capacity = Activity::find($state)?->capacity;
                        $set('capacity', $capacity);
                    })
                    ->searchable()
                    ->preload()
                    ->required()
                    ->rules(function ($get) {
                        return [
                            function (string $attribute, $value, $fail) {
                                if (! $value) {
                                    return;
                                }

                                $act = \App\Models\Activity::query()->find($value);
                                if (! $act || ! $act->is_active) {
                                    $fail('La actividad seleccionada no está activa.');
                                }
                            },
                        ];
                    }),

                Select::make('teacher_id')
                    ->label('Profesor')
                    ->relationship(
                        name: 'teacher',
                        titleAttribute: 'name',
                        modifyQueryUsing: function ($query) {
                            $user = auth()->user();
                            if ($user && $user->isTeacher()) {
                                return $query->where('id', $user->id);
                            }

                            return $query->where('role_id', 2);
                        }
                    )
                    ->preload()
                    ->required()
                    ->searchable()
                    ->default(fn () => auth()->user()?->isTeacher() ? auth()->id() : null)
                    ->disabled(fn () => auth()->user()?->isTeacher())
                    ->dehydrated(true),

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
                    ->options($timeOptions)
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Al cambiar inicio, siempre limpiar fin para forzar selección coherente
                        $set('end_time', null);
                    })
                    ->required(),

                Select::make('end_time')
                    ->label('Hora de fin')
                    ->options(function (callable $get) use ($timeOptions) {
                        $start = $get('start_time');
                        if (! $start) {
                            return $timeOptions;
                        }

                        return collect($timeOptions)->filter(fn ($time) => strcmp($time, $start) > 0);
                    })
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $start = $get('start_time');
                        // Si el usuario elige una hora de fin no válida, la reiniciamos
                        if ($start && $state && strcmp($state, $start) <= 0) {
                            $set('end_time', null);
                        }
                    })
                    ->required()
                    ->rules(function ($get) {
                        return [
                            function (string $attribute, $value, $fail) use ($get) {
                                $start = $get('start_time');
                                if ($start && $value && strcmp($value, $start) <= 0) {
                                    $fail('La hora de fin debe ser mayor que la hora de inicio.');
                                    return;
                                }

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

                TextInput::make('capacity')
                    ->label('Capacidad (desde la actividad)')
                    ->dehydrated(true)
                    ->disabled()
                    ->reactive()
                    ->default(fn ($get) => Activity::find($get('activity_id'))?->capacity)
                    ->helperText('Se toma de la capacidad definida en la actividad.'),
            ]);
    }
}
