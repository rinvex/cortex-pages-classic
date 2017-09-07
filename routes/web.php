<?php

declare(strict_types=1);

Route::group(['domain' => domain()], function () {

    Route::name('adminarea.')
         ->namespace('Cortex\Pages\Http\Controllers\Adminarea')
         ->middleware(['web', 'nohttpcache', 'can:access-dashboard'])
         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}/adminarea' : 'adminarea')->group(function () {

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
