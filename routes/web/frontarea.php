<?php

declare(strict_types=1);

use Cortex\Pages\Http\Controllers\Frontarea\PagesController;

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
