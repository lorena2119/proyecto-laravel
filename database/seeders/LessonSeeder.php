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

        $cards = Card::all()->keyBy('key_phrase');

        $lesson1 = Lesson::create([
            'title' => 'lessons.sections.basic_needs',
            'description' => 'lessons.descriptions.basic_needs',
            'is_daily' => true,
        ]);
        $lesson1->cards()->attach([
            $cards['food']->id => ['order' => 1],
            $cards['bathroom']->id => ['order' => 2],
            $cards['water']->id => ['order' => 3],
        ]);

        $lesson2 = Lesson::create([
            'title' => 'lessons.sections.emotions',
            'description' => 'lessons.descriptions.emotions',
            'is_daily' => false,
        ]);
        $lesson2->cards()->attach([
            $cards['happy']->id => ['order' => 1],
            $cards['sad']->id => ['order' => 2],
            $cards['tired']->id => ['order' => 3],
        ]);

        $lesson3 = Lesson::create([
            'title' => 'lessons.sections.social_communication',
            'description' => 'lessons.descriptions.social_communication',
            'is_daily' => true,
        ]);
        $lesson3->cards()->attach([
            $cards['hello']->id => ['order' => 1],
            $cards['goodbye']->id => ['order' => 2],
            $cards['thanks']->id => ['order' => 3],
        ]);

        $lesson4 = Lesson::create([
            'title' => 'lessons.sections.reinforcement',
            'description' => 'lessons.descriptions.reinforcement',
            'is_daily' => false,
        ]);
        $lesson4->cards()->attach([
            $cards['angry']->id => ['order' => 1],
            $cards['help']->id => ['order' => 2],
            $cards['sleep']->id => ['order' => 3],
        ]);

    }
}