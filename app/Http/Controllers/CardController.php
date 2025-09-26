<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
use App\Traits\ApiResponse;
use App\Models\CardTranslation;
use App\Models\CardQuestion;
use Illuminate\Support\Str;
use App\Http\Requests\StoreCardRequest;
use App\Strategies\VisualStrategy;
use App\Strategies\AuditoryStrategy;
use App\Strategies\TactileStrategy;

class CardController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Iniciar consulta base
        $query = Card::query()->with(['communicationMethod', 'cardTranslations']);
        
        if($request->has('communication_method_id')) {
            $query->where('communication_method_id', $request->input('communication_method_id'));
        }

        $cards =$query->get();

        return $this->success($cards);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCardRequest $request)
    {
        $validatedData = $request->validated();

        // Crear la tarjeta
        $card = Card::create([
            'key_phrase' => $validatedData['key_phrase'],
            'image_path' => $validatedData['image_path'],
            'uuid' => Str::uuid(),
            'communication_method_id' => $validatedData['communication_method_id'],
        ]);

        // Subir y almacenar los archivos MP3
        $audioEsPath = $request->file('audio_es')->store('audios', 'public');
        $audioEnPath = $request->file('audio_en')->store('audios', 'public');

        // Crear traducciones con las rutas de los audios
        CardTranslation::create([
            'card_id' => $card->id,
            'language_code' => 'es',
            'translated_phrase' => $validatedData['translations']['es']['phrase'],
            'audio_path' => $audioEsPath,
        ]);

        CardTranslation::create([
            'card_id' => $card->id,
            'language_code' => 'en',
            'translated_phrase' => $validatedData['translations']['en']['phrase'],
            'audio_path' => $audioEnPath,
        ]);

        // Crear pregunta y respuesta correcta
        CardQuestion::create([
            'card_id' => $card->id,
            'question_text' => $validatedData['question_key'],
            'correct_answer' => $validatedData['correct_answer_key'],
        ]);

        return $this->success($card, 'Tarjeta creada exitosamente.');
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

    public function preferred(Request $request)
{
    $user = $request->user();

    if (!$user || !$user->communication_method_id) {
        // Si el usuario no está logueado o no tiene preferencia, devuelve una colección vacía.
        return $this->success([], 'No se encontró una preferencia de comunicación.');
    }

    $preferredCards = Card::query()
        ->with(['communicationMethod', 'cardTranslations'])
        ->where('communication_method_id', $user->communication_method_id)
        ->get();

    return $this->success($preferredCards, 'Mostrando tarjetas según tu preferencia.');
}

    public function present(Card $card, string $method)
    {
        // Cargamos las traducciones de la tarjeta para que las estrategias puedan usarlas
        $card->load('cardTranslations');

        // Usamos 'match' para una selección más limpia
        $strategy = match ($method) {
            'visual'   => new VisualStrategy(),
            'auditivo' => new AuditoryStrategy(),
            'tactil'   => new TactileStrategy(),
            default    => null,
        };

        if (!$strategy) {
            return $this->error('Método de presentación no soportado', 400);
        }

        $presentationData = $strategy->present($card);

        return $this->success($presentationData, "Presentación de la tarjeta con método {$method}.");
    }
}
