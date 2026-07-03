<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            ConfigSeeder::class,
            // MemberSeeder::class,
            // VentureSeeder::class,
            JobAlertSeeder::class,
            FaqSeeder::class,
        ]);

        // Seed the editable inspirational verse used on the public landing page
        // (editable via Filament Admin → Administración → Textos)
        \App\Models\Text::updateOrCreate(
            ['code' => 'versiculo-de-inspiracion'],
            [
                'type'       => 'versiculo',
                'title'      => 'Proverbios 16:3',
                'content'    => 'Pon en manos del Señor todas tus obras, y tus proyectos se cumplirán.',
                'is_active'  => true,
            ]
        );
    }
}
