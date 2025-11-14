<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Shift extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'activity_id',
        'teacher_id',
        'day_of_week',
        'start_time',
        'end_time',
        'capacity',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'student_shift')
            ->withTimestamps();
    }
}
