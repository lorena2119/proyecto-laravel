<?php
namespace App\Strategies;
use App\Models\Card;

class TactileStrategy implements InteractionStrategy
{
    public function present(Card $card): array
    {
        $locale = app()->getLocale();
        $translation = $card->cardTranslations->where('language_code', $locale)->first();
        
        // Simulamos una respuesta que una app móvil podría usar para vibrar.
        return [
            'presentation_type' => 'tactile',
            'pattern' => 'short_burst_vibration', // Patrón de vibración
            'duration_ms' => 500,                 // Duración en milisegundos
            'description' => 'Simulación de respuesta táctil para: ' . ($translation ? $translation->translated_phrase : $card->key_phrase),
        ];
    }
}