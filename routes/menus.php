<?php

declare(strict_types=1);

use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Factories\MenuFactory;

Menu::modify('adminarea.sidebar', function (MenuFactory $menu) {
    $menu->findByTitleOrAdd(trans('cortex/foundation::common.cms'), 40, 'fa fa-file-text-o', [], function (MenuItem $dropdown) {
        $dropdown->route(['adminarea.pages.index'], trans('cortex/pages::common.pages'), 20, 'fa fa-files-o')->ifCan('list-pages')->activateOnRoute('adminarea.pages');
    });
});

Menu::modify('managerarea.sidebar', function (MenuFactory $menu) {
    $menu->findByTitleOrAdd(trans('cortex/foundation::common.cms'), 40, 'fa fa-file-text-o', [], function (MenuItem $dropdown) {
        $dropdown->route(['managerarea.pages.index'], trans('cortex/pages::common.pages'), 20, 'fa fa-files-o')->ifCan('list-pages')->activateOnRoute('managerarea.pages');
    });
});
