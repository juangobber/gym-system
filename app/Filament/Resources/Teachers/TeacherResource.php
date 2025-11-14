<?php

namespace App\Filament\Resources\Teachers;

use App\Filament\Resources\Teachers\Pages\CreateTeacher;
use App\Filament\Resources\Teachers\Pages\EditTeacher;
use App\Filament\Resources\Teachers\Pages\ListTeachers;
use App\Filament\Resources\Teachers\Schemas\TeacherForm;
use App\Filament\Resources\Teachers\Tables\TeachersTable;
use App\Models\Role;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class TeacherResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;
    protected static UnitEnum|string|null $navigationGroup = 'Administración';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Teachers';
    protected static ?string $modelLabel = 'Teacher';
    protected static ?string $pluralModelLabel = 'Teachers';
    protected static ?string $recordTitleAttribute = 'name';


    public static function form(Schema $schema): Schema
    {
        return TeacherForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TeachersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListTeachers::route('/'),
            'create' => CreateTeacher::route('/create'),
            'edit'   => EditTeacher::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $teacherRoleId = Role::where('name', 'teacher')->value('id');
        return parent::getEloquentQuery()->where('role_id', $teacherRoleId);
    }

    protected static function adminOnly(): bool
    {
        $user = auth()->user();
        return $user && $user->isAdmin();
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
