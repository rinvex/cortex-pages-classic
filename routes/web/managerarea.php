<?php

declare(strict_types=1);

Route::domain('{subdomain}.'.domain())->group(function () {
    Route::name('managerarea.')
         ->namespace('Cortex\Pages\Http\Controllers\Managerarea')
         ->middleware(['web', 'nohttpcache', 'can:access-managerarea'])
         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}/'.config('cortex.foundation.route.prefix.managerarea') : config('cortex.foundation.route.prefix.managerarea'))->group(function () {

            // Pages Routes
             Route::name('pages.')->prefix('pages')->group(function () {
                 Route::get('/')->name('index')->uses('PagesController@index');
                 Route::get('import')->name('import')->uses('PagesController@import');
                 Route::post('import')->name('stash')->uses('PagesController@stash');
                 Route::post('hoard')->name('hoard')->uses('PagesController@hoard');
                 Route::get('import/logs')->name('import.logs')->uses('PagesController@importLogs');
                 Route::get('create')->name('create')->uses('PagesController@form');
                 Route::post('create')->name('store')->uses('PagesController@store');
                 Route::get('{page}')->name('show')->uses('PagesController@show');
                 Route::get('{page}/edit')->name('edit')->uses('PagesController@form');
                 Route::put('{page}/edit')->name('update')->uses('PagesController@update');
                 Route::get('{page}/logs')->name('logs')->uses('PagesController@logs');
                 Route::delete('{page}')->name('destroy')->uses('PagesController@destroy');

                 Route::name('media.')->prefix('{page}/media')->group(function () {
                     Route::get('/')->name('index')->uses('PagesMediaController@index');
                     Route::post('/')->name('store')->uses('PagesMediaController@store');
                     Route::delete('{media}')->name('destroy')->uses('PagesMediaController@destroy');
                 });
             });
         });
});
