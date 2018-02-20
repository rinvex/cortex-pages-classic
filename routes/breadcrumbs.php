<?php

declare(strict_types=1);

use Cortex\Pages\Models\Page;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

// Adminarea breadcrumbs
Breadcrumbs::register('adminarea.pages.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.adminarea'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/pages::common.pages'), route('adminarea.pages.index'));
});

Breadcrumbs::register('adminarea.pages.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.pages.index');
    $breadcrumbs->push(trans('cortex/pages::common.create_page'), route('adminarea.pages.create'));
});

Breadcrumbs::register('adminarea.pages.edit', function (BreadcrumbsGenerator $breadcrumbs, Page $page) {
    $breadcrumbs->parent('adminarea.pages.index');
    $breadcrumbs->push($page->title, route('adminarea.pages.edit', ['page' => $page]));
});

Breadcrumbs::register('adminarea.pages.logs', function (BreadcrumbsGenerator $breadcrumbs, Page $page) {
    $breadcrumbs->parent('adminarea.pages.index');
    $breadcrumbs->push($page->title, route('adminarea.pages.edit', ['page' => $page]));
    $breadcrumbs->push(trans('cortex/pages::common.logs'), route('adminarea.pages.logs', ['page' => $page]));
});

Breadcrumbs::register('adminarea.pages.media.index', function (BreadcrumbsGenerator $breadcrumbs, Page $page) {
    $breadcrumbs->parent('adminarea.pages.index');
    $breadcrumbs->push($page->title, route('adminarea.pages.edit', ['page' => $page]));
    $breadcrumbs->push(trans('cortex/pages::common.media'), route('adminarea.pages.media.index', ['page' => $page]));
});

// Managerarea breadcrumbs
Breadcrumbs::register('managerarea.pages.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.managerarea'), route('managerarea.home'));
    $breadcrumbs->push(trans('cortex/pages::common.pages'), route('managerarea.pages.index'));
});

Breadcrumbs::register('managerarea.pages.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.pages.index');
    $breadcrumbs->push(trans('cortex/pages::common.create_page'), route('managerarea.pages.create'));
});

Breadcrumbs::register('managerarea.pages.edit', function (BreadcrumbsGenerator $breadcrumbs, Page $page) {
    $breadcrumbs->parent('managerarea.pages.index');
    $breadcrumbs->push($page->title, route('managerarea.pages.edit', ['page' => $page]));
});

Breadcrumbs::register('managerarea.pages.logs', function (BreadcrumbsGenerator $breadcrumbs, Page $page) {
    $breadcrumbs->parent('managerarea.pages.index');
    $breadcrumbs->push($page->title, route('managerarea.pages.edit', ['page' => $page]));
    $breadcrumbs->push(trans('cortex/pages::common.logs'), route('managerarea.pages.logs', ['page' => $page]));
});

Breadcrumbs::register('managerarea.pages.media.index', function (BreadcrumbsGenerator $breadcrumbs, Page $page) {
    $breadcrumbs->parent('managerarea.pages.index');
    $breadcrumbs->push($page->title, route('managerarea.pages.edit', ['page' => $page]));
    $breadcrumbs->push(trans('cortex/pages::common.media'), route('managerarea.pages.media.index', ['page' => $page]));
});
