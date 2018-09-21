<?php

declare(strict_types=1);

use Cortex\Pages\Models\Page;
use Rinvex\Menus\Models\MenuItem;
use Spatie\MediaLibrary\Models\Media;
use Rinvex\Menus\Models\MenuGenerator;

Menu::register('adminarea.sidebar', function (MenuGenerator $menu, Page $page) {
    $menu->findByTitleOrAdd(trans('cortex/foundation::common.cms'), 40, 'fa fa-file-text-o', [], function (MenuItem $dropdown) use ($page) {
        $dropdown->route(['adminarea.pages.index'], trans('cortex/pages::common.pages'), 20, 'fa fa-files-o')->ifCan('list', $page)->activateOnRoute('adminarea.pages');
    });
});

Menu::register('adminarea.pages.tabs', function (MenuGenerator $menu, Page $page, Media $media) {
    $menu->route(['adminarea.pages.import'], trans('cortex/bookings::common.records'))->ifCan('import', $page)->if(Route::is('adminarea.pages.import*'));
    $menu->route(['adminarea.pages.import.logs'], trans('cortex/bookings::common.logs'))->ifCan('import', $page)->if(Route::is('adminarea.pages.import*'));
    $menu->route(['adminarea.pages.create'], trans('cortex/bookings::common.details'))->ifCan('create', $page)->if(Route::is('adminarea.pages.create'));
    $menu->route(['adminarea.pages.edit', ['page' => $page]], trans('cortex/bookings::common.details'))->ifCan('update', $page)->if($page->exists);
    $menu->route(['adminarea.pages.logs', ['page' => $page]], trans('cortex/bookings::common.logs'))->ifCan('audit', $page)->if($page->exists);
    $menu->route(['adminarea.pages.media.index', ['page' => $page]], trans('cortex/bookings::common.media'))->ifCan('update', $page)->ifCan('list', $media)->if($page->exists);
});
