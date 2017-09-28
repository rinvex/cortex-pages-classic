<?php

declare(strict_types=1);


use Cortex\Pages\Http\Controllers\Guestarea\PagesController;

app('rinvex.pages.page')->active()->each(function ($page) {
    Route::get($page->uri)
         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}' : '')
         ->name($page->route)
         ->uses(PagesController::class)
         ->middleware($page->middleware ?? ['web'])
         ->domain($page->domain ?? domain())
         ->where('locale', '[a-z]{2}');
});

Route::group(['domain' => domain()], function () {

    Route::name('adminarea.')
         ->namespace('Cortex\Pages\Http\Controllers\Adminarea')
         ->middleware(['web', 'nohttpcache', 'can:access-dashboard'])
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
