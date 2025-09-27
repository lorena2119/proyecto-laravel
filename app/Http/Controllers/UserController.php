<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lesson;
use App\Models\LessonAssignment;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Resources\LessonAssignmentResource;

class UserController extends Controller
{
    use ApiResponse;

    public function getAssignments($id)
    {
        $locale = app()->getLocale();
        $user = User::findOrFail($id);

        // Autorización: Solo el usuario actual o admin puede ver
        $currentUser = auth()->user();
        if (!$currentUser || ($currentUser->id !== $user->id && !$currentUser->hasRole('admin'))) {
            return $this->error(trans('auth.access_denied'), 403);
        }

        // Carga asignaciones con lecciones y traducciones
        $assignments = $user->lessonAssignments()->with([
            'lesson' => function ($query) use ($locale) {
                $query->with(['cards.cardTranslations' => function ($q) use ($locale) {
                    $q->where('language_code', $locale);
                }, 'cards.cardQuestion']);
            }
        ])->get();

        // Retornar con Resource para formatear
        return $this->success(LessonAssignmentResource::collection($assignments), trans('lessons.messages.assignments_retrieved'), 200);
    }
}