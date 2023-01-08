<?php

declare(strict_types=1);

return function () {
    // Bind route models and constrains
    Route::pattern('page', '[a-zA-Z0-9-_]+');
    Route::model('page', config('rinvex.pages.models.page'));
};
