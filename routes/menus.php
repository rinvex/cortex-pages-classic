<?php

declare(strict_types=1);

use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Factories\MenuFactory;

Menu::modify('adminarea.sidebar', function(MenuFactory $menu) {
    $menu->findBy('title', trans('cortex/foundation::common.cms'), function (MenuItem $dropdown) {
        $dropdown->route(['adminarea.pages.index'], trans('cortex/pages::common.pages'), 20, 'fa fa-files-o')->can('list-pages');
    });
});

Menu::modify('managerarea.sidebar', function(MenuFactory $menu) {
    $menu->findBy('title', trans('cortex/foundation::common.cms'), function (MenuItem $dropdown) {
        $dropdown->route(['managerarea.pages.index'], trans('cortex/pages::common.pages'), 20, 'fa fa-files-o')->can('list-pages');
    });
});
