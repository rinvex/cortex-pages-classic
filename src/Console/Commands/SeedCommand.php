<?php

declare(strict_types=1);

namespace Cortex\Pages\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Rinvex\Fort\Traits\AbilitySeeder;
use Rinvex\Fort\Traits\ArtisanHelper;
use Illuminate\Support\Facades\Schema;

class SeedCommand extends Command
{
    use AbilitySeeder;
    use ArtisanHelper;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:seed:pages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed Default Cortex Pages data.';

    /**
     * Execute the console command.
     *
     * @throws \Exception
     *
     * @return void
     */
    public function handle()
    {
        $this->warn('Seed cortex/pages:');

        if ($this->ensureExistingPagesTables()) {
            $seeder = realpath(__DIR__.'/../../../resources/data/pages.json');

            if (! file_exists($seeder)) {
                throw new Exception("Pages seeder file '{$seeder}' does NOT exist!");
            }

            $this->warn('Seeding: '.str_after($seeder, $this->laravel->basePath().'/'));

            // Create new pages
            foreach (json_decode(file_get_contents($seeder), true) as $ability) {
                app('rinvex.pages.page')->firstOrCreate(array_except($ability, ['title']), array_only($ability, ['title']));
            }

            $this->info('Seeded: '.str_after($seeder, $this->laravel->basePath().'/'));
        }

        if ($this->ensureExistingFortTables()) {
            $this->seedAbilities(realpath(__DIR__.'/../../../resources/data/abilities.json'));
        }
    }

    /**
     * Ensure existing pages tables.
     *
     * @return bool
     */
    protected function ensureExistingPagesTables()
    {
        if (! $this->hasPagesTables()) {
            $this->call('cortex:migrate:pages');
        }

        return true;
    }

    /**
     * Check if all required pages tables exists.
     *
     * @return bool
     */
    protected function hasPagesTables()
    {
        return Schema::hasTable(config('rinvex.pages.tables.pages'));
    }
}
