<?php
namespace App\Strategies;
use App\Models\Card;

class AuditoryStrategy implements InteractionStrategy
{
    public function present(Card $card): array
    {
        $locale = app()->getLocale();
        $translation = $card->cardTranslations->where('language_code', $locale)->first();

        return [
            'presentation_type' => 'auditory',
            'audio_path' => $translation ? url('storage/' . $translation->audio_path) : null,
            'description' => $translation ? "Audio para: " . $translation->translated_phrase : "Audio no disponible",
        ];
    }
}