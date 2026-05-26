<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Creamos tres categorías por defecto con colores para identificarlas
        Category::create(['name' => 'Trabajo', 'color' => '#ef4444']);   // Rojo
        Category::create(['name' => 'Estudios', 'color' => '#3b82f6']);  // Azul
        Category::create(['name' => 'Personal', 'color' => '#10b981']);  // Verde
    }
}
