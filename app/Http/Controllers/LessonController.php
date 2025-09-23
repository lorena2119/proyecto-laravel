<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Traits\ApiResponse;

class LessonController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locale = app()->getLocale();

        // Obtener todas las lecciones con sus tarjetas, traducciones y preguntas
        $lessons = Lesson::with(['cards.cardTranslations', 'cards.cardQuestion'])->get();

        // Mapear los datos para incluir traducciones
        $lessonsData = $lessons->map(function ($lesson) use ($locale) {
            return [
                'id' => $lesson->id,
                'title' => trans($lesson->title), // Traducir clave
                'description' => trans($lesson->description), // Traducir clave
                'is_daily' => $lesson->is_daily,
                'created_at' => $lesson->created_at,
                'updated_at' => $lesson->updated_at,
                'cards' => $lesson->cards->map(function ($card) use ($locale) {
                    // Obtener la traducción para el idioma actual desde card_translations
                    $translation = $card->cardTranslations->where('language_code', $locale)->first();
                    $question = $card->cardQuestion; // Puede ser null

                    return [
                        'id' => $card->id,
                        'key_phrase' => trans('cards.key_phrase.' . $card->key_phrase), // Traducir key_phrase
                        'phrase' => $translation ? $translation->translated_phrase : null, // Frase traducida
                        'audio_path' => $translation ? $translation->audio_path : null, // Ruta de audio
                        'question' => $question ? trans($question->question_text) : null, // Traducir clave
                        'correct_answer' => $question ? trans($question->correct_answer) : null, // Traducir clave
                        'order' => $card->pivot->order,
                    ];
                })->sortBy('order')->values(),
            ];
        });

        return $this->success($lessonsData, trans('general.navigation.lessons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
