<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $user = User::findOrFail($id);

        // Autorización: Solo el usuario actual o admin puede ver
        $currentUser = auth()->user();
        if (!$currentUser || ($currentUser->id !== $user->id && !$currentUser->hasRole('admin'))) {
            return $this->error('Acceso denegado', 403);
        }

        // Obtener asignaciones con eager loading para incluir lección
        $assignments = $user->lessonAssignments()->with('lesson')->get();

        // Retornar con Resource para formatear
        return $this->success(LessonAssignmentResource::collection($assignments), 'Asignaciones obtenidas correctamente', 200);
    }
}