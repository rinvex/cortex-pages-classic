<?php

declare(strict_types=1);

namespace Cortex\Pages\Console\Commands;

use Illuminate\Console\ConfirmableTrait;
use Cortex\Foundation\Console\Commands\AbstractModuleCommand;

class DeactivateCommand extends AbstractModuleCommand
{
    use ConfirmableTrait;

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'cortex:deactivate:pages {--f|force : Force the operation to run when in production.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivate Cortex Pages Module';

    /**
     * The current module name.
     *
     * @var string
     */
    protected $module = 'cortex/pages';

    /**
     * Execute the console command.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $this->process($this->module);
    }

    protected function setComposerModuleAttributes(): array
    {
        return $this->getComposerModuleAttributes($this->module, ['active' => false]);
    }
}
