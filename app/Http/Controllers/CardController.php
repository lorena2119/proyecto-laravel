<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
use App\Traits\ApiResponse;
use App\Models\CardTranslation;
use App\Models\CardQuestion;
use Illuminate\Support\Str;
use App\Http\Requests\StoreCardRequest;

class CardController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cards = Card::with('communicationMethod')->get();
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
}
