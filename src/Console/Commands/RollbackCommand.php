<?php

declare(strict_types=1);

namespace Cortex\Pages\Console\Commands;

use Rinvex\Pages\Console\Commands\RollbackCommand as BaseRollbackCommand;

class RollbackCommand extends BaseRollbackCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:rollback:pages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback Cortex Pages Tables.';
}
