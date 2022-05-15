<?php

declare(strict_types=1);

use Cortex\Pages\Models\Page;
use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Models\MenuGenerator;
use Cortex\Foundation\Models\Media;

Menu::register('adminarea.sidebar', function (MenuGenerator $menu) {
    $menu->findByTitleOrAdd(trans('cortex/foundation::common.cms'), 40, 'fa fa-file-text-o', 'header', [], function (MenuItem $dropdown) {
        $dropdown->route(['adminarea.cortex.pages.pages.index'], trans('cortex/pages::common.pages'), 20, 'fa fa-files-o')->ifCan('list', app('rinvex.pages.page'))->activateOnRoute('adminarea.cortex.pages.pages');
    });
});

Menu::register('adminarea.cortex.pages.pages.tabs', function (MenuGenerator $menu, Page $page, Media $media) {
    $menu->route(['adminarea.cortex.pages.pages.import'], trans('cortex/pages::common.records'))->ifCan('import', $page)->if(Route::is('adminarea.cortex.pages.pages.import*'));
    $menu->route(['adminarea.cortex.pages.pages.import.logs'], trans('cortex/pages::common.logs'))->ifCan('import', $page)->if(Route::is('adminarea.cortex.pages.pages.import*'));
    $menu->route(['adminarea.cortex.pages.pages.create'], trans('cortex/pages::common.details'))->ifCan('create', $page)->if(Route::is('adminarea.cortex.pages.pages.create'));
    $menu->route(['adminarea.cortex.pages.pages.edit', ['page' => $page]], trans('cortex/pages::common.details'))->ifCan('update', $page)->if($page->exists);
    $menu->route(['adminarea.cortex.pages.pages.logs', ['page' => $page]], trans('cortex/pages::common.logs'))->ifCan('audit', $page)->if($page->exists);
    $menu->route(['adminarea.cortex.pages.pages.media.index', ['page' => $page]], trans('cortex/pages::common.media'))->ifCan('update', $page)->ifCan('list', $media)->if($page->exists);
});
