<?php

declare(strict_types=1);

namespace Cortex\Pages\Providers;

use Cortex\Pages\Models\Page;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Rinvex\Support\Traits\ConsoleTools;
use Illuminate\Contracts\Events\Dispatcher;
use Cortex\Pages\Console\Commands\SeedCommand;
use Cortex\Pages\Console\Commands\UnloadCommand;
use Cortex\Pages\Console\Commands\InstallCommand;
use Cortex\Pages\Console\Commands\MigrateCommand;
use Cortex\Pages\Console\Commands\PublishCommand;
use Cortex\Pages\Console\Commands\ActivateCommand;
use Cortex\Pages\Console\Commands\RollbackCommand;
use Cortex\Pages\Console\Commands\AutoloadCommand;
use Cortex\Pages\Console\Commands\DeactivateCommand;
use Illuminate\Database\Eloquent\Relations\Relation;

class PagesServiceProvider extends ServiceProvider
{
    use ConsoleTools;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        ActivateCommand::class => 'command.cortex.pages.activate',
        DeactivateCommand::class => 'command.cortex.pages.deactivate',
        AutoloadCommand::class => 'command.cortex.pages.autoload',
        UnloadCommand::class => 'command.cortex.pages.unload',

        SeedCommand::class => 'command.cortex.pages.seed',
        InstallCommand::class => 'command.cortex.pages.install',
        MigrateCommand::class => 'command.cortex.pages.migrate',
        PublishCommand::class => 'command.cortex.pages.publish',
        RollbackCommand::class => 'command.cortex.pages.rollback',
    ];

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register(): void
    {
        // Bind eloquent models to IoC container
        $this->app['config']['rinvex.pages.models.page'] === Page::class
        || $this->app->alias('rinvex.pages.page', Page::class);

        // Register console commands
        $this->registerCommands($this->commands);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router, Dispatcher $dispatcher): void
    {
        // Bind route models and constrains
        $router->pattern('page', '[a-zA-Z0-9-_]+');
        $router->model('page', config('rinvex.pages.models.page'));

        // Map relations
        Relation::morphMap([
            'page' => config('rinvex.pages.models.page'),
        ]);
    }
}
