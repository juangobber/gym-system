<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Routine extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'name',
        'description',
        'start_date',
        'end_date',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

}

