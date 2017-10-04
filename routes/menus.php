<?php

declare(strict_types=1);

Menu::adminareaSidebar('resources')->routeIfCan('list-pages', 'adminarea.pages.index', '<i class="fa fa-files-o"></i> <span>'.trans('cortex/pages::common.pages').'</span>');
Menu::tenantareaSidebar('resources')->routeIfCan('list-pages', 'tenantarea.pages.index', '<i class="fa fa-files-o"></i> <span>'.trans('cortex/pages::common.pages').'</span>');
