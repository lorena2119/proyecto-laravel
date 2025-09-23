<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\Card;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class LessonSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener tarjetas por key_phrase
        $cards = Card::all()->keyBy('key_phrase');

        // Lección 1: Necesidades básicas 
        $lesson1 = Lesson::create([
            'title' => 'Rutina matutina: Mis necesidades', // Título específico en DB
            'description' => trans('lessons.descriptions.basic_needs'), // Descripción de lang/
            'is_daily' => true,
        ]);
        $lesson1->cards()->attach([
            $cards['food']->id => ['order' => 1],
            $cards['bathroom']->id => ['order' => 2],
            $cards['water']->id => ['order' => 3],
        ]);

        // Lección 2: Expresar emociones
        $lesson2 = Lesson::create([
            'title' => 'Mis emociones de hoy', // Título específico en DB
            'description' => trans('lessons.descriptions.emotions'), // Descripción de lang/
            'is_daily' => false,
        ]);
        $lesson2->cards()->attach([
            $cards['happy']->id => ['order' => 1],
            $cards['sad']->id => ['order' => 2],
            $cards['tired']->id => ['order' => 3],
        ]);

        // Lección 3: Comunicación social básica
        $lesson3 = Lesson::create([
            'title' => 'Hablar con amigos y familia', // Título específico en DB
            'description' => trans('lessons.descriptions.social_communication'), // Descripción de lang/
            'is_daily' => true,
        ]);
        $lesson3->cards()->attach([
            $cards['hello']->id => ['order' => 1],
            $cards['goodbye']->id => ['order' => 2],
            $cards['thanks']->id => ['order' => 3],
        ]);

        // Lección 4: Refuerzo general
        $lesson4 = Lesson::create([
            'title' => 'Práctica semanal de refuerzo', // Título específico en DB
            'description' => trans('lessons.descriptions.reinforcement'), // Descripción de lang/
            'is_daily' => false,
        ]);
        $lesson4->cards()->attach([
            $cards['angry']->id => ['order' => 1],
            $cards['help']->id => ['order' => 2],
            $cards['sleep']->id => ['order' => 3],
        ]);
    }
}