<?php

namespace App\Filament\Pages;

use App\Models\User;
use BackedEnum;
use UnitEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class UserProfile extends Page
{
    // Icono del menú lateral
    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedUserCircle;

    protected static ?string $navigationLabel = 'Mi perfil';
    protected static ?string $title = 'Perfil de usuario';
    protected static UnitEnum|string|null $navigationGroup = 'Usuario';
    protected static ?string $slug = 'perfil';


    // ⚠️ NO static
    protected string $view = 'filament.pages.user-profile';

    public ?User $user = null;

    public function mount(): void
    {
        $this->user = Auth::user();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check();
    }

    public static function canAccess(array $parameters = []): bool
    {
        return auth()->check();
    }
}
