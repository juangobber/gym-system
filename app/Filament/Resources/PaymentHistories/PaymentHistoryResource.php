<?php

namespace App\Filament\Resources\PaymentHistories;

use App\Filament\Resources\PaymentHistories\Pages\ListPaymentHistories;
use App\Filament\Resources\PaymentHistories\Schemas\PaymentHistoryForm;
use App\Filament\Resources\PaymentHistories\Tables\PaymentHistoriesTable;
use App\Models\Payment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class PaymentHistoryResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;
    protected static ?string $navigationLabel = 'Historial de pagos';
    protected static UnitEnum|string|null $navigationGroup = 'Administración';
    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'paid_at';

    public static function form(Schema $schema): Schema
    {
        return PaymentHistoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PaymentHistoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPaymentHistories::route('/'),
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
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }
}
