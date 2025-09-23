<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'card_id',
        'language_code',
        'translated_phrase',
        'audio_path',
    ];

    
    public function card()
    {
        return $this->belongsTo(Card::class);
    }
}
