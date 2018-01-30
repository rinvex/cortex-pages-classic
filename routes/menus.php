<?php

declare(strict_types=1);

use Cortex\Pages\Models\Page;
use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Models\MenuGenerator;

Menu::register('adminarea.sidebar', function (MenuGenerator $menu) {
    $menu->findByTitleOrAdd(trans('cortex/foundation::common.cms'), 40, 'fa fa-file-text-o', [], function (MenuItem $dropdown) {
        $dropdown->route(['adminarea.pages.index'], trans('cortex/pages::common.pages'), 20, 'fa fa-files-o')->ifCan('list-pages')->activateOnRoute('adminarea.pages');
    });
});

Menu::register('managerarea.sidebar', function (MenuGenerator $menu) {
    $menu->findByTitleOrAdd(trans('cortex/foundation::common.cms'), 40, 'fa fa-file-text-o', [], function (MenuItem $dropdown) {
        $dropdown->route(['managerarea.pages.index'], trans('cortex/pages::common.pages'), 20, 'fa fa-files-o')->ifCan('list-pages')->activateOnRoute('managerarea.pages');
    });
});

Menu::register('adminarea.pages.tabs', function (MenuGenerator $menu, Page $page) {
    $menu->route(['adminarea.pages.create'], trans('cortex/bookings::common.details'))->ifCan('create-pages')->if(! $page->exists);
    $menu->route(['adminarea.pages.edit', ['page' => $page]], trans('cortex/bookings::common.details'))->ifCan('update-pages')->if($page->exists);
    $menu->route(['adminarea.pages.logs', ['page' => $page]], trans('cortex/bookings::common.logs'))->ifCan('update-pages')->if($page->exists);
    $menu->route(['adminarea.pages.media.index', ['page' => $page]], trans('cortex/bookings::common.media'))->ifCan('list-media-pages')->if($page->exists);
});

Menu::register('managerarea.pages.tabs', function (MenuGenerator $menu, Page $page) {
    $menu->route(['managerarea.pages.create'], trans('cortex/bookings::common.details'))->ifCan('create-pages')->if(! $page->exists);
    $menu->route(['managerarea.pages.edit', ['page' => $page]], trans('cortex/bookings::common.details'))->ifCan('update-pages')->if($page->exists);
    $menu->route(['managerarea.pages.logs', ['page' => $page]], trans('cortex/bookings::common.logs'))->ifCan('update-pages')->if($page->exists);
    $menu->route(['managerarea.pages.media.index', ['page' => $page]], trans('cortex/bookings::common.media'))->ifCan('list-media-pages')->if($page->exists);
});
