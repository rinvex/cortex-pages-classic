<?php

declare(strict_types=1);

namespace Cortex\Pages\Console\Commands;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:publish:pages {--force : Overwrite any existing files.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish Cortex Pages Resources.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->warn('Publish cortex/pages:');
        $this->call('vendor:publish', ['--tag' => 'rinvex-pages-config', '--force' => $this->option('force')]);
        $this->call('vendor:publish', ['--tag' => 'cortex-pages-views', '--force' => $this->option('force')]);
        $this->call('vendor:publish', ['--tag' => 'cortex-pages-lang', '--force' => $this->option('force')]);
    }
}
