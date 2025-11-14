<?php

namespace App\Filament\Resources\Routines\Pages;

use App\Filament\Resources\Routines\RoutineResource;
use App\Models\Routine;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewRoutine extends ViewRecord
{
    protected static string $resource = RoutineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Volver')
                ->icon('heroicon-m-arrow-uturn-left')
                ->color('gray')
                ->url('/admin/perfil'),
        ];
    }

    public static function canAccess(array $parameters = []): bool
    {
        return auth()->check();
    }
}
