<?php

namespace App\Filament\Resources\Roles;

use App\Filament\Resources\Roles\Pages\CreateRole;
use App\Filament\Resources\Roles\Pages\EditRole;
use App\Filament\Resources\Roles\Pages\ListRoles;
use App\Filament\Resources\Roles\Schemas\RoleForm;
use App\Filament\Resources\Roles\Tables\RolesTable;
use App\Models\Role;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;
    protected static UnitEnum|string|null $navigationGroup = 'Administración';
    protected static ?int $navigationSort = 4;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return RoleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RolesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }

    protected static function adminOnly(): bool
    {
        $user = auth()->user();
        return $user && $user->isAdmin();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::adminOnly();
    }

    public static function canViewAny(): bool
    {
        return static::adminOnly();
    }

    public static function canView(?Model $record): bool
    {
        return static::adminOnly();
    }

    public static function canCreate(): bool
    {
        return static::adminOnly();
    }

    public static function canEdit(Model $record): bool
    {
        return static::adminOnly();
    }

    public static function canDelete(Model $record): bool
    {
        return static::adminOnly();
    }

    public static function canDeleteAny(): bool
    {
        return static::adminOnly();
    }
}
