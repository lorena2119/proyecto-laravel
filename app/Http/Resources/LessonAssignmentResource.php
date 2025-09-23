<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonAssignmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'lesson_id' => $this->lesson_id,
            'assigned_at' => $this->assigned_at->format('Y-m-d H:i:s'), // Formatear fecha
            'completed_at' => $this->completed_at ? $this->completed_at->format('Y-m-d H:i:s') : null,
            'lesson' => [ // Incluir datos básicos de la lección relacionada
                'title' => $this->lesson->title,
                'description' => $this->lesson->description,
                'is_daily' => $this->lesson->is_daily,
            ],
            // Puedes agregar más, e.g., cards si necesitas: 'cards' => $this->lesson->cards
        ];
    }
}
