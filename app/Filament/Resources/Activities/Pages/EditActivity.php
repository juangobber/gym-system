<?php

namespace App\Filament\Resources\Activities\Pages;

use App\Filament\Resources\Activities\ActivityResource;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;
use Filament\Resources\Pages\EditRecord;

class EditActivity extends EditRecord
{
    protected static string $resource = ActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->requiresConfirmation()
                ->action(function ($record) {
                    if ($record->shifts()->exists()) {
                        Notification::make()
                            ->title('No se puede eliminar')
                            ->body('Primero elimina los turnos asociados a esta actividad.')
                            ->danger()
                            ->send();
                        return;
                    }
                    $record->delete();
                    Notification::make()->title('Actividad eliminada')->success()->send();
                }),
        ];
    }

    protected function beforeSave(): void
    {
        // Si intenta desactivar una actividad con turnos, impedir guardar y mostrar notificación
        $isActive = (bool) ($this->data['is_active'] ?? true);
        if ($this->record && ! $isActive && $this->record->shifts()->exists()) {
            Notification::make()
                ->title('No se puede desactivar')
                ->body('Hay turnos asociados a esta actividad. Elimínalos primero.')
                ->danger()
                ->send();

            $this->halt();
        }
    }
}
