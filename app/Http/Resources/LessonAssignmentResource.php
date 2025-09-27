<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonAssignmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();

        return [
            'id' => $this->id,
            'lesson_id' => $this->lesson_id,
            'assigned_at' => $this->assigned_at instanceof \Carbon\Carbon 
                ? $this->assigned_at->format('Y-m-d H:i:s') 
                : $this->assigned_at,
            'completed_at' => $this->completed_at instanceof \Carbon\Carbon 
                ? $this->completed_at->format('Y-m-d H:i:s') 
                : $this->completed_at,
            'lesson' => $this->when($this->lesson, function () use ($locale) {
                return [
                    'id' => $this->lesson->id,
                    'title' => trans($this->lesson->title), // Traducir
                    'description' => trans($this->lesson->description), // Traducir
                    'is_daily' => $this->lesson->is_daily,
                    'created_at' => $this->lesson->created_at,
                    'updated_at' => $this->lesson->updated_at,
                    'cards' => $this->lesson->cards->map(function ($card) use ($locale) {
                        $translation = $card->cardTranslations->where('language_code', $locale)->first();
                        $question = $card->cardQuestion;

                        return [
                            'id' => $card->id,
                            'key_phrase' => trans('cards.key_phrase.' . $card->key_phrase), // Traducir
                            'phrase' => $translation ? $translation->translated_phrase : null,
                            'audio_path' => $translation ? $translation->audio_path : null,
                            'question' => $question ? trans($question->question_text) : null,
                        ];
                    })->sortBy('order')->values(),
                ];
            }, null),
        ];
    }
}