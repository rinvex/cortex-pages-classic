<?php

declare(strict_types=1);

namespace Cortex\Pages\Console\Commands;

use Illuminate\Console\Command;
use Rinvex\Support\Traits\SeederHelper;

class SeedCommand extends Command
{
    use SeederHelper;

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
    protected $description = 'Seed Cortex Pages Data.';

    /**
     * Execute the console command.
     *
     * @throws \Exception
     *
     * @return void
     */
    public function handle()
    {
        $this->warn($this->description);

        if ($this->ensureExistingDatabaseTables('rinvex/pages')) {
            $this->seedResources(app('rinvex.pages.page'), realpath(__DIR__.'/../../../resources/data/pages.json'), ['title', 'view'], function ($ids) {
                // Update page route domain
                app('rinvex.pages.page')->whereIn('id', $ids)->update(['domain' => domain()]);
            });
        }

        if ($this->ensureExistingDatabaseTables('rinvex/fort')) {
            $this->seedResources(app('rinvex.fort.ability'), realpath(__DIR__.'/../../../resources/data/abilities.json'), ['name', 'description', 'policy']);
        }
    }
}
