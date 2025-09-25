<?php
namespace App\Strategies;
use App\Models\Card;

interface InteractionStrategy
{
    // El método que todas las estrategias deberán implementar
    public function present(Card $card): array;
}