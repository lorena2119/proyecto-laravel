<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'key_phrase' => 'required|string|unique:cards,key_phrase',
            'image_path' => 'required|string',
            'communication_method_id' => 'required|exists:communication_methods,id',
            'translations.es.phrase' => 'required|string',
            'translations.en.phrase' => 'required|string',
            'audio_es' => 'required|file|mimes:mp3|max:10240', // 10MB máximo
            'audio_en' => 'required|file|mimes:mp3|max:10240', // 10MB máximo
            'question_key' => 'required|string',
            'correct_answer_key' => 'required|string',
        ];
    }
}
