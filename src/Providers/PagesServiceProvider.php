<?php

declare(strict_types=1);

namespace Cortex\Pages\Providers;

use Rinvex\Pages\Models\Page;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Cortex\Pages\Console\Commands\SeedCommand;
use Cortex\Pages\Console\Commands\InstallCommand;
use Cortex\Pages\Console\Commands\MigrateCommand;
use Cortex\Pages\Console\Commands\PublishCommand;
use Cortex\Pages\Console\Commands\RollbackCommand;
use Illuminate\Database\Eloquent\Relations\Relation;

class PagesServiceProvider extends ServiceProvider
{
    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
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
        $this->mergeConfigFrom(realpath(__DIR__.'/../../config/config.php'), 'cortex.pages');

        // Register console commands
        ! $this->app->runningInConsole() || $this->registerCommands();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router): void
    {
        // Bind route models and constrains
        $router->pattern('page', '[0-9a-z\._-]+');
        $router->model('page', Page::class);

        // Map relations
        Relation::morphMap([
            'page' => config('rinvex.pages.models.page'),
        ]);

        // Load resources
        require __DIR__.'/../../routes/breadcrumbs.php';
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'cortex/pages');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'cortex/pages');
        ! $this->app->runningInConsole() || $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->app->afterResolving('blade.compiler', function () {
            require __DIR__.'/../../routes/menus.php';
        });

        // Publish Resources
        ! $this->app->runningInConsole() || $this->publishResources();
    }

    /**
     * Publish resources.
     *
     * @return void
     */
    protected function publishResources(): void
    {
        $this->publishes([realpath(__DIR__.'/../../config/config.php') => config_path('cortex.pages.php')], 'cortex-pages-config');
        $this->publishes([realpath(__DIR__.'/../../database/migrations') => database_path('migrations')], 'cortex-pages-migrations');
        $this->publishes([realpath(__DIR__.'/../../resources/lang') => resource_path('lang/vendor/cortex/pages')], 'cortex-pages-lang');
        $this->publishes([realpath(__DIR__.'/../../resources/views') => resource_path('views/vendor/cortex/pages')], 'cortex-pages-views');
    }

    /**
     * Register console commands.
     *
     * @return void
     */
    protected function registerCommands(): void
    {
        // Register artisan commands
        foreach ($this->commands as $key => $value) {
            $this->app->singleton($value, $key);
        }

        $this->commands(array_values($this->commands));
    }
}
