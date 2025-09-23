<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\CardTranslation;
use App\Models\CardQuestion;
use App\Models\CommunicationMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CardSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            'visual' => CommunicationMethod::where('type', 'visual')->first()->id,
            'auditory' => CommunicationMethod::where('type', 'auditory')->first()->id,
            'tactile' => CommunicationMethod::where('type', 'tactile')->first()->id,
        ];

        // Array de datos para las 12 tarjetas
        $cardsData = [
            // Necesidades básicas
            [
                'key_phrase' => 'food',
                'image_path' => 'https://st2.depositphotos.com/27811286/44302/v/950/depositphotos_443029058-stock-illustration-happy-cute-kid-boy-girl.jpg',
                'method' => $methods['visual'],
                'translations' => [
                    'es' => ['phrase' => 'Quiero comer', 'audio' => 'storage/audios/es/comer.mp3'],
                    'en' => ['phrase' => 'I want to eat', 'audio' => 'storage/audios/en/eat.mp3'],
                ],
                'question_key' => 'cards.questions.food',
                'correct_answer_key' => 'cards.correct_answers.food', // Clave de lang/
            ],
            [
                'key_phrase' => 'bathroom',
                'image_path' => 'https://thumbs.dreamstime.com/b/el-ni%C3%B1o-quiere-ir-al-ba%C3%B1o-estudiante-la-caricatura-del-276423901.jpg',
                'method' => $methods['visual'],
                'translations' => [
                    'es' => ['phrase' => 'Necesito ir al baño', 'audio' => 'storage/audios/es/bano.mp3'],
                    'en' => ['phrase' => 'I need to use the bathroom', 'audio' => 'storage/audios/en/bathroom.mp3'],
                ],
                'question_key' => 'cards.questions.bathroom',
                'correct_answer_key' => 'cards.correct_answers.bathroom',
            ],
            [
                'key_phrase' => 'sleep',
                'image_path' => 'https://img.freepik.com/vector-premium/linda-nina-bostezando-sueno_535862-1011.jpg',
                'method' => $methods['auditory'],
                'translations' => [
                    'es' => ['phrase' => 'Quiero dormir', 'audio' => 'storage/audios/es/dormir.mp3'],
                    'en' => ['phrase' => 'I want to sleep', 'audio' => 'storage/audios/en/sleep.mp3'],
                ],
                'question_key' => 'cards.questions.sleep',
                'correct_answer_key' => 'cards.correct_answers.sleep',
            ],
            [
                'key_phrase' => 'water',
                'image_path' => 'https://media.istockphoto.com/id/1193410235/es/vector/ni%C3%B1o-lindo-feliz-se-siente-tan-sediento.jpg?s=612x612&w=0&k=20&c=J-8HqT5DN74zBR3be7KPPysfMoZf1aW052M-eWx5A6I=',
                'method' => $methods['tactile'],
                'translations' => [
                    'es' => ['phrase' => 'Quiero agua', 'audio' => 'storage/audios/es/agua.mp3'],
                    'en' => ['phrase' => 'I want water', 'audio' => 'storage/audios/en/water.mp3'],
                ],
                'question_key' => 'cards.questions.water',
                'correct_answer_key' => 'cards.correct_answers.water',
            ],
            // Emociones
            [
                'key_phrase' => 'happy',
                'image_path' => 'storage/images/happy-face.png',
                'method' => $methods['visual'],
                'translations' => [
                    'es' => ['phrase' => 'Me siento feliz', 'audio' => 'storage/audios/es/feliz.mp3'],
                    'en' => ['phrase' => 'I feel happy', 'audio' => 'storage/audios/en/happy.mp3'],
                ],
                'question_key' => 'cards.questions.happy',
                'correct_answer_key' => 'cards.correct_answers.happy',
            ],
            [
                'key_phrase' => 'sad',
                'image_path' => 'storage/images/sad-face.png',
                'method' => $methods['visual'],
                'translations' => [
                    'es' => ['phrase' => 'Me siento triste', 'audio' => 'storage/audios/es/triste.mp3'],
                    'en' => ['phrase' => 'I feel sad', 'audio' => 'storage/audios/en/sad.mp3'],
                ],
                'question_key' => 'cards.questions.sad',
                'correct_answer_key' => 'cards.correct_answers.sad',
            ],
            [
                'key_phrase' => 'tired',
                'image_path' => 'storage/images/tired-face.jpg',
                'method' => $methods['auditory'],
                'translations' => [
                    'es' => ['phrase' => 'Estoy cansado', 'audio' => 'storage/audios/es/cansado.mp3'],
                    'en' => ['phrase' => 'I am tired', 'audio' => 'storage/audios/en/tired.mp3'],
                ],
                'question_key' => 'cards.questions.tired',
                'correct_answer_key' => 'cards.correct_answers.tired',
            ],
            [
                'key_phrase' => 'angry',
                'image_path' => 'storage/images/angry-face.jpg',
                'method' => $methods['tactile'],
                'translations' => [
                    'es' => ['phrase' => 'Estoy enojado', 'audio' => 'storage/audios/es/enojado.mp3'],
                    'en' => ['phrase' => 'I am angry', 'audio' => 'storage/audios/en/angry.mp3'],
                ],
                'question_key' => 'cards.questions.angry',
                'correct_answer_key' => 'cards.correct_answers.angry',
            ],
            // Acciones sociales
            [
                'key_phrase' => 'hello',
                'image_path' => 'https://img.freepik.com/vector-premium/retrato-mujer-saludando_869472-225.jpg',
                'method' => $methods['visual'],
                'translations' => [
                    'es' => ['phrase' => 'Hola', 'audio' => 'storage/audios/es/hola.mp3'],
                    'en' => ['phrase' => 'Hello', 'audio' => 'storage/audios/en/hello.mp3'],
                ],
                'question_key' => 'cards.questions.hello',
                'correct_answer_key' => 'cards.correct_answers.hello',
            ],
            [
                'key_phrase' => 'goodbye',
                'image_path' => 'https://www.shutterstock.com/image-vector/woman-saying-goodbye-flat-design-600nw-2205459797.jpg',
                'method' => $methods['visual'],
                'translations' => [
                    'es' => ['phrase' => 'Adiós', 'audio' => 'storage/audios/es/adios.mp3'],
                    'en' => ['phrase' => 'Goodbye', 'audio' => 'storage/audios/en/goodbye.mp3'],
                ],
                'question_key' => 'cards.questions.goodbye',
                'correct_answer_key' => 'cards.correct_answers.goodbye',
            ],
            [
                'key_phrase' => 'thanks',
                'image_path' => 'https://static.vecteezy.com/system/resources/previews/002/710/702/non_2x/thank-you-illustration-with-cartoon-characters-vector.jpg',
                'method' => $methods['auditory'],
                'translations' => [
                    'es' => ['phrase' => 'Gracias', 'audio' => 'storage/audios/es/gracias.mp3'],
                    'en' => ['phrase' => 'Thank you', 'audio' => 'storage/audios/en/thankyou.mp3'],
                ],
                'question_key' => 'cards.questions.thanks',
                'correct_answer_key' => 'cards.correct_answers.thanks',
            ],
            [
                'key_phrase' => 'help',
                'image_path' => 'https://img.freepik.com/vector-premium/mujer-necesita-ayuda-chica-e-inscripcion-me-ayudan-persona-estres-personaje-vector-estilo-dibujos-animados_499739-727.jpg',
                'method' => $methods['tactile'],
                'translations' => [
                    'es' => ['phrase' => 'Necesito ayuda', 'audio' => 'storage/audios/es/ayuda.mp3'],
                    'en' => ['phrase' => 'I need help', 'audio' => 'storage/audios/en/help.mp3'],
                ],
                'question_key' => 'cards.questions.help',
                'correct_answer_key' => 'cards.correct_answers.help',
            ],
        ];

        foreach ($cardsData as $data) {
            $card = Card::create([
                'key_phrase' => $data['key_phrase'],
                'image_path' => $data['image_path'],
                'uuid' => Str::uuid(),
                'communication_method_id' => $data['method'],
            ]);

            // Traducciones dinámicas en DB
            foreach ($data['translations'] as $lang => $translation) {
                CardTranslation::firstOrCreate([
                    'card_id' => $card->id,
                    'language_code' => $lang,
                    'translated_phrase' => $translation['phrase'],
                    'audio_path' => $translation['audio'],
                ]);
            }

            // Pregunta y respuesta correcta con claves de lang/
            CardQuestion::firstOrCreate([
                'card_id' => $card->id,
                'question_text' => $data['question_key'], // 'cards.questions.food'
                'correct_answer' => $data['correct_answer_key'], // 'cards.correct_answers.food'
            ]);
        }
    }
}