<?php

namespace App\Filament\Resources\Shifts\Schemas;

use App\Models\Shift;
use App\Models\Activity;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Filament\Schemas\Components\Section;

class ShiftForm
{
    public static function configure(Schema $schema): Schema
    {
        $timeOptions = collect(range(8 * 60, 21 * 60, 15))->mapWithKeys(function ($minutes) {
            $label = sprintf('%02d:%02d', floor($minutes / 60), $minutes % 60);
            $value = $label . ':00';
            return [$value => $label];
        })->all();

        return $schema
            ->components([
                Section::make('Información del turno')
            ->schema([
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

                        return collect($timeOptions)->filter(fn ($label, $time) => strcmp($time, $start) > 0);
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
 
                                // Excluir el turno que se está editando para permitir actualizarlo sin conflicto
                                $currentId = $get('id') ?? request()->route('record');
                                $exists = Shift::query()
                                    ->where('day_of_week', $day)
                                    ->where('start_time', $start)
                                    ->where('end_time', $end)
                                    ->when($currentId, fn ($q) => $q->whereKeyNot($currentId))
                                    ->exists();

                                if ($exists) {
                                    $fail('Ya existe un turno con ese día y horario.');
                                }
                            },
                        ];
                    }),

                TextInput::make('capacity')
                    ->label('Capacidad')
                    ->numeric()
                    ->minValue(1)
                    ->required()
                    ->dehydrated(true)
                    ->reactive()
                    ->default(fn ($get) => Activity::find($get('activity_id'))?->capacity)
                    ->rules(function ($get) {
                        return [
                            function (string $attribute, $value, $fail) use ($get) {
                                if ($value === null) {
                                    return;
                                }

                                $activityId = $get('activity_id');
                                if (! $activityId) {
                                    return;
                                }

                                $activityCapacity = Activity::find($activityId)?->capacity;
                                if ($activityCapacity !== null && $value > $activityCapacity) {
                                    $fail("La capacidad del turno no puede ser mayor que la capacidad de la actividad ({$activityCapacity}).");
                                }
                            },
                        ];
                    })
                    ->helperText('Se toma de la capacidad definida en la actividad.'),
            ])

            ]);
    }
}
