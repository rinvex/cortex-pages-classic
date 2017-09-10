<?php

declare(strict_types=1);

namespace Cortex\Pages\Console\Commands;

use Rinvex\Pages\Console\Commands\MigrateCommand as BaseMigrateCommand;

class MigrateCommand extends BaseMigrateCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:migrate:pages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Cortex Pages Tables.';
}
