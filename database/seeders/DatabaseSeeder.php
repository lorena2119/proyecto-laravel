<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan; // ← Importación CORRECTA
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
        ]);

    // Limpiar cache de configuración (importante para lang/)
        $this->clearCaches();
        
        // Deshabilitar claves foráneas temporalmente para seeders
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        $this->call([
            CommunicationMethodSeeder::class,
        
            CardSeeder::class,
            
            LessonSeeder::class,
            
        ]);
        
        // Reactivar claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Limpiar cache después de seeding
        $this->clearCaches();
        
        $this->info('Database seeding completed successfully!');
    }
    
    /**
     * Limpiar caches de Laravel
     */
    private function clearCaches(): void
    {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
    }
    
    /**
     * Mostrar información de progreso
     */
    private function info(string $message): void
    {
        echo "\n✅ " . $message . "\n";
    }
}