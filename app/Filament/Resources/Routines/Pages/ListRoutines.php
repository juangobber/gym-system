<?php

namespace App\Filament\Resources\Routines\Pages;

use App\Filament\Resources\Routines\RoutineResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRoutines extends ListRecords
{
    protected static string $resource = RoutineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn () => auth()->user()?->isAdmin() || auth()->user()?->isTeacher()),
        ];
    }

    public static function canAccess(array $parameters = []): bool
    {
        return auth()->check();
    }
}
