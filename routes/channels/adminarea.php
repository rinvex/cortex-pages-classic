<?php

declare(strict_types=1);

Broadcast::channel('adminarea-pages-index', function ($user) {
    return $user->can('list', app('rinvex.pages.page'));
}, ['guards' => ['admin']]);
