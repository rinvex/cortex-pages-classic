<?php

declare(strict_types=1);

use Cortex\Pages\Models\Page;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('managerarea.pages.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('rinvex.tenants.active')->name, route('managerarea.home'));
    $breadcrumbs->push(trans('cortex/pages::common.pages'), route('managerarea.pages.index'));
});

Breadcrumbs::register('managerarea.pages.import', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.pages.index');
    $breadcrumbs->push(trans('cortex/pages::common.import'), route('managerarea.pages.import'));
});

Breadcrumbs::register('managerarea.pages.import.logs', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.pages.index');
    $breadcrumbs->push(trans('cortex/pages::common.import'), route('managerarea.pages.import'));
    $breadcrumbs->push(trans('cortex/pages::common.logs'), route('managerarea.pages.import.logs'));
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
