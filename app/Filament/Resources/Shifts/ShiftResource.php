<?php

namespace App\Filament\Resources\Shifts;

use App\Filament\Resources\Shifts\Pages\CreateShift;
use App\Filament\Resources\Shifts\Pages\EditShift;
use App\Filament\Resources\Shifts\Pages\ListShifts;
use App\Filament\Resources\Shifts\Schemas\ShiftForm;
use App\Filament\Resources\Shifts\Tables\ShiftsTable;
use App\Models\Shift;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use UnitEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ShiftResource extends Resource
{
    protected static ?string $model = Shift::class;

    protected static UnitEnum|string|null $navigationGroup = 'Gimnasio';
    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedClock;
    protected static ?string $navigationLabel = 'Turnos';
    protected static ?string $modelLabel = 'Turno';
    protected static ?string $pluralModelLabel = 'Turnos';

     public static function form(Schema $schema): Schema
    {
        return ShiftForm::configure($schema);

    }

    public static function table(Table $table): Table
    {
        return ShiftsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListShifts::route('/'),
            'create' => CreateShift::route('/create'),
            'edit' => EditShift::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user && $user->isTeacher()) {
            return $query->where('teacher_id', $user->id);
        }

        return $query;
    }

    protected static function userCanManage(?Model $record = null): bool
    {
        $user = auth()->user();
        if (! $user) {
            return false;
        }

        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isTeacher()) {
            return $record ? $record->teacher_id === $user->id : true;
        }

        return false;
    }

    public static function canViewAny(): bool
    {
        return static::userCanManage();
    }

    public static function canView(?Model $record): bool
    {
        return static::userCanManage($record);
    }

    public static function canCreate(): bool
    {
        $user = auth()->user();
        return $user && ($user->isAdmin() || $user->isTeacher());
    }

    public static function canEdit(Model $record): bool
    {
        return static::userCanManage($record);
    }

    public static function canDelete(Model $record): bool
    {
        return static::userCanManage($record);
    }

    public static function canDeleteAny(): bool
    {
        $user = auth()->user();
        return $user && $user->isAdmin();
    }
}
