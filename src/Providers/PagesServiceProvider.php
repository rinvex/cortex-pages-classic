<?php

declare(strict_types=1);

namespace Cortex\Pages\Providers;

use Illuminate\Support\ServiceProvider;

class PagesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Load resources
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'cortex/pages');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'cortex/pages');

        // Publish Resources
        ! $this->app->runningInConsole() || $this->publishResources();

        // Register sidebar menus
        $this->app->singleton('menus.sidebar.management', function ($app) {
            return collect();
        });

        // Register menu items
        $this->app['view']->composer('cortex/foundation::backend.partials.sidebar', function ($view) {
            app('menus.sidebar')->put('management', app('menus.sidebar.management'));
            app('menus.sidebar.management')->put('header', '<li class="header">'.trans('cortex/pages::navigation.headers.management').'</li>');
            app('menus.sidebar.management')->put('pages', '<li '.(mb_strpos(request()->route()->getName(), 'backend.pages.') === 0 ? 'class="active"' : '').'><a href="'.route('backend.pages.index').'"><i class="fa fa-files-o"></i> <span>'.trans('cortex/pages::navigation.menus.pages').'</span></a></li>');
        });
    }

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Publish resources.
     *
     * @return void
     */
    protected function publishResources()
    {
        $this->publishes([realpath(__DIR__.'/../../resources/lang') => resource_path('lang/vendor/cortex/pages')], 'lang');
        $this->publishes([realpath(__DIR__.'/../../resources/views') => resource_path('views/vendor/cortex/pages')], 'views');
    }
}
