<?php

namespace App\Filament\Resources\Activities\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rules\Unique;
use App\Models\Shift;

class ActivityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    // Único ignorando el propio registro y también ignorando los soft-deleted
                    ->unique(ignoreRecord: true, modifyRuleUsing: function (Unique $rule) {
                        return $rule->whereNull('deleted_at');
                    }),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('capacity')
                    ->label('Capacidad')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(200)
                    ->required()
                    ->rule(function ($attribute, $value, $fail) {
                        $recordId = request()->route('record');
                        if (! $recordId) {
                            return;
                        }

                        $maxEnrolled = Shift::query()
                            ->where('activity_id', $recordId)
                            ->withCount('students')
                            ->get()
                            ->max('students_count') ?? 0;

                        if ((int) $value < $maxEnrolled) {
                            $fail("La capacidad no puede ser menor a {$maxEnrolled} alumnos inscriptos.");
                        }
                    }),
                Toggle::make('is_active')
                    ->visible(fn ($livewire) => $livewire instanceof \App\Filament\Resources\Activities\Pages\EditActivity)
                    ->default(true)
            ]);
    }
}
