<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    public $tableName = 'configs';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $configData = config('app_config');

        // Ensure textTypes for the Versículo editable content (and other types)
        $configData['textTypes'] = array_merge(
            $configData['textTypes'] ?? [],
            [
                'ui'        => 'UI / Contenido Público',
                'mail'      => 'Plantillas de Correo',
                'versiculo' => 'Versículo de Inspiración',
            ]
        );

        // Ensure 'categories' scope map so CategoryResource "Para" select (and the generic admin
        // category UI) can offer entries for both Emprendimientos and the later-added Bolsa de Trabajo.
        // Uses actual scope column values. Labels match the documented Sistema > Configuración intent.
        $configData['categories'] = array_merge(
            $configData['categories'] ?? [],
            [
                'Venture'    => 'Emprendimiento',
                'JobListing' => 'Bolsa de Trabajo',
            ]
        );

        Config::updateOrCreate(
            ['name' => 'default'],
            ['jsondata' => $configData]
        );
    }
}
