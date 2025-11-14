<?php

namespace App\Filament\Pages;

use App\Models\Shift;
use BackedEnum;
use UnitEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Filament\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;




class AvailableShifts extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedCalendarDays;
    protected static ?string $navigationLabel = 'Turnos disponibles';
    protected static UnitEnum|string|null $navigationGroup = 'Usuario';
    protected static ?string $title = 'Turnos disponibles';
    protected static ?int $navigationSort = 2;

    // Renderizaremos la tabla en esta vista
    protected string $view = 'filament.pages.available-shifts';

    public static function canAccess(array $parameters = []): bool
    {
        $user = auth()->user();
        return $user && ($user->isAdmin() || $user->isTeacher() || $user->isStudent());
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canAccess();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Shift::query()
                    ->with(['activity','teacher'])
                    ->withCount('students') // genera 'students_count'
            )
            ->columns([
                TextColumn::make('activity.name')
                    ->label('Actividad')
                    ->sortable()
                    ->searchable()
                    ->limit(32),

                TextColumn::make('teacher.name')
                    ->label('Profesor')
                    ->sortable()
                    ->searchable()
                    ->limit(32),

                TextColumn::make('day_of_week')
                    ->label('Día')
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'monday' => 'Lunes',
                        'tuesday' => 'Martes',
                        'wednesday' => 'Miércoles',
                        'thursday' => 'Jueves',
                        'friday' => 'Viernes',
                        'saturday' => 'Sábado',
                        'sunday' => 'Domingo',
                        default => $state,
                    })
                    ->sortable(),

                TextColumn::make('start_time')
                    ->label('Hora de inicio')
                        ->time('H:i:s')   // muestra 08:00:00
                        ->sortable(),

                TextColumn::make('end_time')
                    ->label('Hora de fin')
                    ->time('H:i:s') 
                    ->sortable(),

                TextColumn::make('capacity')
                    ->label('Capacidad')
                    ->alignCenter()
                    ->sortable(),
                
                TextColumn::make('available_spots')
                    ->label('Cupos disponibles')
                    ->alignCenter()
                    ->getStateUsing(fn (Shift $record): int => max($record->capacity - ($record->students_count ?? 0), 0))
                    ->sortable(),

                BadgeColumn::make('estado')
                    ->label('Estado')
                    ->state(function (Shift $record): string {
                        $userId = Auth::id();
                        if (!$userId) {
                            return '—';
                        }
                    
                        $enrolled = $record->students()->where('user_id', $userId)->exists();
                        if ($enrolled) {
                            return 'Inscripto';
                        }
                    
                        $available = $record->capacity - ($record->students_count ?? 0);
                        if ($available <= 0) {
                            return 'Sin cupos';
                        }
                    
                        return 'Inscribirse';
                    })
                    ->colors([
                        'success' => fn (string $state) => $state === 'Inscripto',
                        'danger'  => fn (string $state) => $state === 'Sin cupos',
                        'primary' => fn (string $state) => $state === 'Inscribirse',
                    ]),
            ])
            ->filters([
                SelectFilter::make('activity_id')
                    ->label('Actividad')
                    ->relationship('activity', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('teacher_id')
                    ->label('Profesor')
                    ->relationship('teacher', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('day_of_week')
                    ->label('Día')
                    ->options([
                        'monday' => 'Lunes',
                        'tuesday' => 'Martes',
                        'wednesday' => 'Miércoles',
                        'thursday' => 'Jueves',
                        'friday' => 'Viernes',
                        'saturday' => 'Sábado',
                        'sunday' => 'Domingo',
                    ]),
            ])
            ->actions([
            Action::make('toggle-enrollment')
                ->label(function (Shift $record): string {
                    $userId = Auth::id();
                    if (!$userId) return 'Inscribirse';
                    $enrolled = $record->students()->where('user_id', $userId)->exists();
                    return $enrolled ? 'Desinscribirse' : 'Inscribirse';
                })
                ->icon(fn (Shift $r) =>
                    $r->students()->where('user_id', Auth::id())->exists()
                        ? 'heroicon-m-x-circle' : 'heroicon-m-check'
                )
                ->color(fn (Shift $r) =>
                    $r->students()->where('user_id', Auth::id())->exists()
                        ? 'danger' : 'primary'
                )
                ->disabled(function (Shift $r): bool {
                    $userId = Auth::id();
                    if (!$userId) return true;
                    $enrolled = $r->students()->where('user_id', $userId)->exists();
                    if ($enrolled) return false;
                    $available = $r->capacity - ($r->students_count ?? 0);
                    return $available <= 0;
                })
                ->requiresConfirmation()
                ->visible(fn () => Auth::check() && (Auth::user()->role_id ?? null) === 3)
                ->action(function (Shift $r) {
                    $userId = Auth::id();
                    if (!$userId) return;

                    $enrolled = $r->students()->where('user_id', $userId)->exists();

                    if (! $enrolled) {
                        // Cupos
                        $available = $r->capacity - ($r->students_count ?? 0);
                        if ($available <= 0) {
                            Notification::make()->title('Sin cupos')->danger()->send();
                            return;
                        }
                        // Solapamiento (mismo día y rango intersecta)
                        $overlap = Shift::whereHas('students', fn ($q) => $q->where('user_id', $userId))
                            ->where('day_of_week', $r->day_of_week)
                            ->where('start_time', '<', $r->end_time)
                            ->where('end_time', '>', $r->start_time)
                            ->exists();

                        if ($overlap) {
                            Notification::make()
                                ->title('Conflicto de horario')
                                ->body('Ya estás inscripto en un turno que se solapa con este.')
                                ->warning()->send();
                            return;
                        }

                        $r->students()->attach($userId);
                        Notification::make()->title('Inscripción confirmada')->success()->send();
                    } else {
                        $r->students()->detach($userId);
                        Notification::make()->title('Desinscripción realizada')->success()->send();
                    }
                }),
        ])
            ->paginated([10, 25, 50])
            ->striped()
            ->emptyStateHeading('No hay turnos disponibles');
    }
}
