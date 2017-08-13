<?php

declare(strict_types=1);

Menu::backendSidebar('resources')->routeIfCan('list-pages', 'backend.pages.index', '<i class="fa fa-files-o"></i> <span>'.trans('cortex/pages::common.pages').'</span>');
