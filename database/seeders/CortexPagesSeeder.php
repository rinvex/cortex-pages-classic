<?php

declare(strict_types=1);

namespace Cortex\Pages\Database\Seeders;

use Illuminate\Database\Seeder;

class CortexPagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $abilities = [
            ['name' => 'list', 'title' => 'List pages', 'entity_type' => 'page'],
            ['name' => 'view', 'title' => 'View pages', 'entity_type' => 'page'],
            ['name' => 'import', 'title' => 'Import pages', 'entity_type' => 'page'],
            ['name' => 'export', 'title' => 'Export pages', 'entity_type' => 'page'],
            ['name' => 'create', 'title' => 'Create pages', 'entity_type' => 'page'],
            ['name' => 'update', 'title' => 'Update pages', 'entity_type' => 'page'],
            ['name' => 'delete', 'title' => 'Delete pages', 'entity_type' => 'page'],
            ['name' => 'audit', 'title' => 'Audit pages', 'entity_type' => 'page'],
        ];

        collect($abilities)->each(function (array $ability) {
            app('cortex.auth.ability')->firstOrCreate([
                'name' => $ability['name'],
                'entity_type' => $ability['entity_type'],
            ], $ability);
        });
    }
}
