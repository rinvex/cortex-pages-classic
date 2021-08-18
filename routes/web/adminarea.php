<?php

declare(strict_types=1);

Route::domain('{central_domain}')->group(function () {
    Route::name('adminarea.')
         ->namespace('Cortex\Pages\Http\Controllers\Adminarea')
         ->middleware(['web', 'nohttpcache', 'can:access-adminarea'])
         ->prefix(route_prefix('adminarea'))->group(function () {

        // Pages Routes
             Route::name('cortex.pages.pages.')->prefix('pages')->group(function () {
                 Route::match(['get', 'post'], '/')->name('index')->uses('PagesController@index');
                 Route::get('import')->name('import')->uses('PagesController@import');
                 Route::post('import')->name('stash')->uses('PagesController@stash');
                 Route::post('hoard')->name('hoard')->uses('PagesController@hoard');
                 Route::get('import/logs')->name('import.logs')->uses('PagesController@importLogs');
                 Route::get('create')->name('create')->uses('PagesController@create');
                 Route::post('create')->name('store')->uses('PagesController@store');
                 Route::get('{page}')->name('show')->uses('PagesController@show');
                 Route::get('{page}/edit')->name('edit')->uses('PagesController@edit');
                 Route::put('{page}/edit')->name('update')->uses('PagesController@update');
                 Route::match(['get', 'post'], '{page}/logs')->name('logs')->uses('PagesController@logs');
                 Route::delete('{page}')->name('destroy')->uses('PagesController@destroy');

                 Route::name('media.')->prefix('{page}/media')->group(function () {
                     Route::get('/')->name('index')->uses('PagesMediaController@index');
                     Route::post('/')->name('store')->uses('PagesMediaController@store');
                     Route::delete('{media}')->name('destroy')->uses('PagesMediaController@destroy');
                 });
             });
         });
});
