<?php

declare(strict_types=1);

use App\Cortex\Pages\Models\Page;
use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Models\MenuGenerator;

Menu::register('managerarea.sidebar', function (MenuGenerator $menu) {
    $menu->findByTitleOrAdd(trans('cortex/foundation::common.cms'), 40, 'fa fa-file-text-o', 'header', [], function (MenuItem $dropdown) use ($page) {
        $dropdown->route(['managerarea.cortex.pages.pages.index'], trans('cortex/pages::common.pages'), 20, 'fa fa-files-o')->ifCan('list', $page)->activateOnRoute('managerarea.cortex.pages.pages');
    });
});