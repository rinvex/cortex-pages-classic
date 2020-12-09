<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Access\Authorizable;

Broadcast::channel('rinvex.pages.pages.index', function (Authorizable $user) {
    return $user->can('list', app('rinvex.pages.page'));
}, ['guards' => ['admin']]);
