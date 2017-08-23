<?php

declare(strict_types=1);

use Rinvex\Pages\Contracts\PageContract;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('backend.pages.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.backend'), route('backend.home'));
    $breadcrumbs->push(trans('cortex/pages::common.pages'), route('backend.pages.index'));
});

Breadcrumbs::register('backend.pages.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('backend.pages.index');
    $breadcrumbs->push(trans('cortex/pages::common.create_page'), route('backend.pages.create'));
});

Breadcrumbs::register('backend.pages.edit', function (BreadcrumbsGenerator $breadcrumbs, PageContract $page) {
    $breadcrumbs->parent('backend.pages.index');
    $breadcrumbs->push($page->title, route('backend.pages.edit', ['page' => $page]));
});

Breadcrumbs::register('backend.pages.logs', function (BreadcrumbsGenerator $breadcrumbs, PageContract $page) {
    $breadcrumbs->parent('backend.pages.index');
    $breadcrumbs->push($page->title, route('backend.pages.edit', ['page' => $page]));
    $breadcrumbs->push(trans('cortex/pages::common.logs'), route('backend.pages.logs', ['page' => $page]));
});
