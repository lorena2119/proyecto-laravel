<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'is_daily',
    ];

    
    public function cards()
    {
        return $this->belongsToMany(Card::class, 'lesson_card')
                    ->withPivot('order');
    }

    public function lessonAssignments()
    {
        return $this->hasMany(LessonAssignment::class);
    }
}
