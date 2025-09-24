<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lesson;
use App\Models\LessonAssignment;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Resources\LessonAssignmentResource; // Lo crearemos después

class UserController extends Controller
{
    use ApiResponse;

    /**
     * Obtiene las asignaciones de lecciones de un usuario.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAssignments($id)
    {
        $locale = app()->getLocale();
        $user = User::findOrFail($id);
        $user_id = $user->id;

        // Autorización: Solo el usuario actual o admin puede ver
        $currentUser = auth()->user();
        if (!$currentUser || ($currentUser->id !== $user->id && !$currentUser->hasRole('admin'))) {
            return $this->error('Acceso denegado', 403);
        }

        $lesson = Lesson::with(['cards.cardTranslations', 'cards.cardQuestion'])->findOrFail($id);
        $assignments = LessonAssignment::findOrFail($user_id);
        // Mapear los datos para incluir traducciones
        $lessonData = [
            'id' => $assignments->id,
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
                ];
            })->sortBy('order')->values(),
        ];

        // Obtener asignaciones con eager loading para incluir lección
        

        // Retornar con Resource para formatear
        return $this->success($lessonData, trans('lessons.messages.new_lesson'), 200);
    }
}