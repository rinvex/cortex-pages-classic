<?php

declare(strict_types=1);

namespace Cortex\Pages\Providers;

use Cortex\Pages\Models\Page;
use Illuminate\Support\ServiceProvider;
use Rinvex\Support\Traits\ConsoleTools;

class PagesServiceProvider extends ServiceProvider
{
    use ConsoleTools;

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
        $this->registerModels([
            'rinvex.pages.page' => Page::class,
        ]);
    }
}
