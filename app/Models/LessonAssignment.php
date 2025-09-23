<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lesson_id',
        'assigned_at',
        'completed_at',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function userCardResponses()
    {
        return $this->hasMany(UserCardResponse::class);
    }

    public function progress()
    {
        return $this->hasMany(Progress::class);
    }
}
