<?php

declare(strict_types=1);

namespace Cortex\Pages\Console\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Rinvex\Pages\Console\Commands\RollbackCommand as BaseRollbackCommand;

#[AsCommand(name: 'cortex:rollback:pages')]
class RollbackCommand extends BaseRollbackCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:rollback:pages {--f|force : Force the operation to run when in production.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback Cortex Pages Tables.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $path = config('cortex.pages.autoload_migrations') ?
            'app/cortex/pages/database/migrations' :
            'database/migrations/cortex/pages';

        if (file_exists($path)) {
            $this->call('migrate:reset', [
                '--path' => $path,
                '--force' => $this->option('force'),
            ]);
        } else {
            $this->warn('No migrations found! Consider publish them first: <fg=green>php artisan cortex:publish:pages</>');
        }

        parent::handle();
    }
}
