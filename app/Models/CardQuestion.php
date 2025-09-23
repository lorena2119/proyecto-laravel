<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'card_id',
        'question_text',
        'correct_answer',
    ];

    
    public function card()
    {
        return $this->belongsTo(Card::class);
    }
}
