<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Traits\ApiResponse;
use Illuminate\Support\Str;

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
        // Validar datos de entrada
    $validatedData = $request->validate([
        'title_es' => 'required|string|max:255',
        'title_en' => 'required|string|max:255',
        'description_es' => 'required|string',
        'description_en' => 'required|string',
        'is_daily' => 'required|boolean',
        'cards' => 'required|array', // Array de IDs de tarjetas y orden
        'cards.*.id' => 'required|exists:cards,id',
        'cards.*.order' => 'required|integer|min:1',
    ]);

    // Generar claves de traducción únicas
    $titleKey = 'lessons.sections.' . Str::slug($validatedData['title_es'], '_');
    $descriptionKey = 'lessons.descriptions.' . Str::slug($validatedData['title_es'], '_');

    // Crear la lección con las claves de traducción
    $lesson = Lesson::create([
        'title' => $titleKey,
        'description' => $descriptionKey,
        'is_daily' => $validatedData['is_daily'],
    ]);

    // Asociar tarjetas con orden
    $attachData = [];
    foreach ($validatedData['cards'] as $card) {
        $attachData[$card['id']] = ['order' => $card['order']];
    }
    $lesson->cards()->attach($attachData);

    // Actualizar archivos de idioma
    $this->updateLanguageFiles([
        'es' => [
            $titleKey => $validatedData['title_es'],
            $descriptionKey => $validatedData['description_es'],
        ],
        'en' => [
            $titleKey => $validatedData['title_en'],
            $descriptionKey => $validatedData['description_en'],
        ],
    ]);

    return $this->success($lesson, 'Lección creada exitosamente.');
    }


    protected function updateLanguageFiles(array $translations)
    {
        foreach ($translations as $locale => $data) {
            $path = resource_path("lang/{$locale}/lessons.php");
            $currentTranslations = file_exists($path) ? include $path : [];

            $newTranslations = array_merge($currentTranslations, [$data]);
            ksort($newTranslations);

            $content = "<?php\n\nreturn " . var_export($newTranslations, true) . ";\n";
            file_put_contents($path, $content);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $locale = app()->getLocale();

        $lesson = Lesson::with(['cards.cardTranslations', 'cards.cardQuestion'])->findOrFail($id);

        // Mapear los datos para incluir traducciones
        $lessonData = [
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

        return $this->success($lessonData, trans('general.navigation.lessons'). " #".$id);
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
