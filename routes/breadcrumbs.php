<?php

declare(strict_types=1);

use Rinvex\Pages\Contracts\PageContract;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('adminarea.pages.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.adminarea'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/pages::common.pages'), route('adminarea.pages.index'));
});

Breadcrumbs::register('adminarea.pages.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.pages.index');
    $breadcrumbs->push(trans('cortex/pages::common.create_page'), route('adminarea.pages.create'));
});

Breadcrumbs::register('adminarea.pages.edit', function (BreadcrumbsGenerator $breadcrumbs, PageContract $page) {
    $breadcrumbs->parent('adminarea.pages.index');
    $breadcrumbs->push($page->title, route('adminarea.pages.edit', ['page' => $page]));
});

Breadcrumbs::register('adminarea.pages.logs', function (BreadcrumbsGenerator $breadcrumbs, PageContract $page) {
    $breadcrumbs->parent('adminarea.pages.index');
    $breadcrumbs->push($page->title, route('adminarea.pages.edit', ['page' => $page]));
    $breadcrumbs->push(trans('cortex/pages::common.logs'), route('adminarea.pages.logs', ['page' => $page]));
});
