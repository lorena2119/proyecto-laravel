<?php
namespace App\Strategies;
use App\Models\Card;

class VisualStrategy implements InteractionStrategy
{
    public function present(Card $card): array
    {
        $locale = app()->getLocale(); // Obtiene el idioma actual (ej: 'es', 'en')
        // Busca la traducción específica para el idioma actual
        $translation = $card->cardTranslations->where('language_code', $locale)->first();

        return [
            'presentation_type' => 'visual',
            'image_path' => $card->image_path,
            'phrase' => $translation ? $translation->translated_phrase : $card->key_phrase,
        ];
    }
}