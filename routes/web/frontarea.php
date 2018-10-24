<?php

declare(strict_types=1);

use Cortex\Pages\Http\Controllers\Frontarea\PagesController;

try {
    // Just check if we have DB connection! This is to avoid
    // exceptions on new projects before configuring database options
    DB::connection()->getPdo();

    if (Schema::hasTable(config('rinvex.pages.tables.pages'))) {
        app('rinvex.pages.page')->where('is_active', true)->get()->groupBy('domain')->each(function ($pages, $domain) {
            Route::domain($domain ?? domain())->group(function () use ($pages) {
                $pages->each(function ($page) {
                    Route::get($page->uri)
                         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}' : '')
                         ->name($page->route)
                         ->uses(PagesController::class)
                         ->middleware($page->middleware ?? ['web'])
                         ->where('locale', '[a-z]{2}');
                });
            });
        });
    }
} catch (Exception $e) {
    // Be quite! Do not do or say anything!!
}
