<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunicationMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'description',
    ];

    
    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
