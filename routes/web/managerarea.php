<?php

declare(strict_types=1);

use Cortex\Pages\Http\Controllers\Managerarea\PagesController;
use Cortex\Pages\Http\Controllers\Managerarea\PagesMediaController;

Route::domain('{managerarea}')->group(function () {
    Route::name('managerarea.')
         ->middleware(['web', 'nohttpcache', 'can:access-managerarea'])
         ->prefix(route_prefix('managerarea'))->group(function () {
             // Pages Routes
             Route::name('cortex.pages.pages.')->prefix('pages')->group(function () {
                 Route::match(['get', 'post'], '/')->name('index')->uses([PagesController::class, 'index']);
                 Route::post('import')->name('import')->uses([PagesController::class, 'import']);
                 Route::get('create')->name('create')->uses([PagesController::class, 'create']);
                 Route::post('create')->name('store')->uses([PagesController::class, 'store']);
                 Route::get('{page}')->name('show')->uses([PagesController::class, 'show']);
                 Route::get('{page}/edit')->name('edit')->uses([PagesController::class, 'edit']);
                 Route::put('{page}/edit')->name('update')->uses([PagesController::class, 'update']);
                 Route::match(['get', 'post'], '{page}/logs')->name('logs')->uses([PagesController::class, 'logs']);
                 Route::delete('{page}')->name('destroy')->uses([PagesController::class, 'destroy']);

                 Route::name('media.')->prefix('{page}/media')->group(function () {
                     Route::get('/')->name('index')->uses([PagesMediaController::class, 'index']);
                     Route::post('/')->name('store')->uses([PagesMediaController::class, 'store']);
                     Route::delete('{media}')->name('destroy')->uses([PagesMediaController::class, 'destroy']);
                 });
             });
         });
});
