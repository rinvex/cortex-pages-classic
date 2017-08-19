<?php

declare(strict_types=1);

Route::group(['domain' => domain()], function () {

    Route::name('backend.')
         ->namespace('Cortex\Pages\Http\Controllers\Backend')
         ->middleware(['web', 'nohttpcache', 'can:access-dashboard'])
         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}/backend' : 'backend')->group(function () {

        // Pages Routes
        Route::name('pages.')->prefix('pages')->group(function () {
            Route::get('/')->name('index')->uses('PagesController@index');
            Route::get('create')->name('create')->uses('PagesController@form');
            Route::post('create')->name('store')->uses('PagesController@store');
            Route::get('{page}')->name('edit')->uses('PagesController@form')->where('page', '[0-9]+');
            Route::put('{page}')->name('update')->uses('PagesController@update')->where('page', '[0-9]+');
            Route::get('{page}/logs')->name('logs')->uses('PagesController@logs')->where('page', '[0-9]+');
            Route::delete('{page}')->name('delete')->uses('PagesController@delete')->where('page', '[0-9]+');
        });

    });

});
