<?php

namespace App\Filament\Resources\Payments\Payments;

use App\Filament\Resources\Payments\Payments\Pages\CreatePayment;
use App\Filament\Resources\Payments\Payments\Pages\ListPayments;
use App\Filament\Resources\Payments\Payments\Schemas\PaymentForm;
use App\Filament\Resources\Payments\Payments\Tables\PaymentsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PaymentResource extends Resource
{
    protected static ?string $model = \App\Models\Payment::class;

    protected static \BackedEnum|string|null $navigationIcon = \Filament\Support\Icons\Heroicon::OutlinedRectangleStack;
    protected static \UnitEnum|string|null $navigationGroup = 'Administración';
    protected static ?string $navigationLabel = 'Pagos';
    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return PaymentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PaymentsTable::configure($table);
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
            'index' => ListPayments::route('/'),
            'create' => CreatePayment::route('/create'),
            // 'edit' => EditPayment::route('/{record}/edit'),  // opcional
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
