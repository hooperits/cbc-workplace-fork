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

        Config::updateOrCreate(
            ['name' => 'default'],
            ['jsondata' => $configData]
        );
    }
}
