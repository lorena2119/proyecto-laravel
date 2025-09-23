<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'key_phrase',
        'image_path',
        'uuid',
        'communication_method_id',
    ];

    
    public function communicationMethod()
    {
        return $this->belongsTo(CommunicationMethod::class);
    }

    public function cardTranslations()
    {
        return $this->hasMany(CardTranslation::class);
    }

    public function cardQuestion()
    {
        return $this->hasOne(CardQuestion::class);
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'lesson_card')
                    ->withPivot('order');
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