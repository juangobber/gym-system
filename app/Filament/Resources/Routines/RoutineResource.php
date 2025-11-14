<?php

namespace App\Filament\Resources\Routines;

use App\Filament\Resources\Routines\Pages\CreateRoutine;
use App\Filament\Resources\Routines\Pages\EditRoutine;
use App\Filament\Resources\Routines\Pages\ListRoutines;
use App\Filament\Resources\Routines\Pages\ViewRoutine;
use App\Filament\Resources\Routines\Schemas\RoutineForm;
use App\Filament\Resources\Routines\Tables\RoutinesTable;
use App\Models\Routine;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;
use Filament\Infolists\Components\TextEntry;


class RoutineResource extends Resource
{
    protected static ?string $model = Routine::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static UnitEnum|string|null $navigationGroup = 'Gimnasio';
    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return RoutineForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RoutinesTable::configure($table);
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
            'index' => ListRoutines::route('/'),
            'create' => CreateRoutine::route('/create'),
            'edit' => EditRoutine::route('/{record}/edit'),
            'view' => ViewRoutine::route('/{record}'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check();
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user && $user->isStudent()) {
            return $query->where('student_id', $user->id);
        }

        return $query;
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            TextEntry::make('student.name')->label('Student'),
            TextEntry::make('name')->label('Name'),
            TextEntry::make('start_date')->label('Start date'),
            TextEntry::make('end_date')->label('End date')->placeholder('—'),
            TextEntry::make('description')
                ->label('Description')
                ->columnSpanFull()
                ->prose()
                ->hidden(fn ($state) => blank($state)),
        ]);
    }

    protected static function userCanManage(): bool
    {
        $user = auth()->user();
        return $user && ($user->isAdmin() || $user->isTeacher());
    }

    public static function canViewAny(): bool
    {
        return auth()->check();
    }

    public static function canView(?Model $record): bool
    {
        return auth()->check();
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
