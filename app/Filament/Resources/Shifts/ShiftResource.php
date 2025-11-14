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

class ShiftResource extends Resource
{
    protected static ?string $model = Shift::class;

    protected static UnitEnum|string|null $navigationGroup = 'Gimnasio';
    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $navigationLabel = 'Turnos';

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

    protected static function userCanManage(): bool
    {
        $user = auth()->user();
        return $user && ($user->isAdmin() || $user->isTeacher());
    }

    public static function canViewAny(): bool
    {
        return static::userCanManage();
    }

    public static function canView(?Model $record): bool
    {
        return static::userCanManage();
    }

    public static function canCreate(): bool
    {
        return static::userCanManage();
    }

    public static function canEdit(Model $record): bool
    {
        return static::userCanManage();
    }

    public static function canDelete(Model $record): bool
    {
        return static::userCanManage();
    }

    public static function canDeleteAny(): bool
    {
        return static::userCanManage();
    }
}
