<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'capacity',
    ];

    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }

    protected static function booted(): void
    {
        static::saving(function (Activity $activity) {
            if (! $activity->exists) {
                return;
            }

            if (! $activity->isDirty('capacity')) {
                return;
            }

            $maxEnrolled = $activity->shifts()
                ->withCount('students')
                ->get()
                ->max('students_count') ?? 0;

            if ((int) $activity->capacity < $maxEnrolled) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'capacity' => "La capacidad no puede ser menor a {$maxEnrolled} alumnos ya inscriptos.",
                ]);
            }
        });

        static::saved(function (Activity $activity) {
            if ($activity->wasChanged('capacity')) {
                $activity->shifts()->update(['capacity' => $activity->capacity]);
            }
        });
    }
}
