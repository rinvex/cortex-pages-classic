<?php

declare(strict_types=1);


use Cortex\Pages\Http\Controllers\Guestarea\PagesController;

if (Schema::hasTable(config('rinvex.pages.tables.pages'))) {
    app('rinvex.pages.page')->active()->get()->groupBy('domain')->each(function ($pages, $domain) {

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

Route::domain(domain())->group(function () {

    Route::name('adminarea.')
         ->namespace('Cortex\Pages\Http\Controllers\Adminarea')
         ->middleware(['web', 'nohttpcache', 'can:access-adminarea'])
         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}/'.config('cortex.foundation.route.prefix.adminarea') : config('cortex.foundation.route.prefix.adminarea'))->group(function () {

        // Pages Routes
        Route::name('pages.')->prefix('pages')->group(function () {
            Route::get('/')->name('index')->uses('PagesController@index');
            Route::get('create')->name('create')->uses('PagesController@form');
            Route::post('create')->name('store')->uses('PagesController@store');
            Route::get('{page}')->name('edit')->uses('PagesController@form');
            Route::put('{page}')->name('update')->uses('PagesController@update');
            Route::get('{page}/logs')->name('logs')->uses('PagesController@logs');
            Route::delete('{page}')->name('delete')->uses('PagesController@delete');
        });

    });

});
