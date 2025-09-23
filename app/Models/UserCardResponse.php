<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCardResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'card_id',
        'lesson_assignment_id',
        'response',
        'score',
        'responded_at',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    public function lessonAssignment()
    {
        return $this->belongsTo(LessonAssignment::class);
    }
}
