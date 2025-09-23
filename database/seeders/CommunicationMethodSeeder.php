<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CommunicationMethod;

class CommunicationMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CommunicationMethod::query()->insert([
        ['type'=>'visual','description'=>'Basado en imágenes, colores, gestos o símbolos que facilitan la comprensión a través de la vista.', 'created_at'=>now(),'updated_at'=>now()],
        ['type'=>'auditory','description'=>'Utiliza sonidos, palabras habladas, música o entonaciones para transmitir mensajes mediante la audición.','created_at'=>now(),'updated_at'=>now()],
        ['type'=>'tactile','description'=>'Se apoya en el contacto físico o texturas (como el braille o señales táctiles) para comunicar información a través del tacto.','created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
