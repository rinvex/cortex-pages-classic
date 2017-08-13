<?php

declare(strict_types=1);

namespace Cortex\Pages\Console\Commands;

use Illuminate\Console\Command;
use Cortex\Fort\Traits\AbilitySeeder;
use Cortex\Fort\Traits\BaseFortSeeder;
use Illuminate\Support\Facades\Schema;

class SeedCommand extends Command
{
    use AbilitySeeder;
    use BaseFortSeeder;

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
     * @return void
     */
    public function handle()
    {
        if ($this->ensureExistingPagesTables()) {
            // No seed data at the moment!
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
