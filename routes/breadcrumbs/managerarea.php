<?php

declare(strict_types=1);

use Cortex\Pages\Models\Page;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('managerarea.cortex.pages.pages.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.app('request.tenant')->name, route('managerarea.home'));
    $breadcrumbs->push(trans('cortex/pages::common.pages'), route('managerarea.cortex.pages.pages.index'));
});

Breadcrumbs::register('managerarea.cortex.pages.pages.import', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.cortex.pages.pages.index');
    $breadcrumbs->push(trans('cortex/pages::common.import'), route('managerarea.cortex.pages.pages.import'));
});

Breadcrumbs::register('managerarea.cortex.pages.pages.import.logs', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.cortex.pages.pages.index');
    $breadcrumbs->push(trans('cortex/pages::common.import'), route('managerarea.cortex.pages.pages.import'));
    $breadcrumbs->push(trans('cortex/pages::common.logs'), route('managerarea.cortex.pages.pages.import.logs'));
});

Breadcrumbs::register('managerarea.cortex.pages.pages.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.cortex.pages.pages.index');
    $breadcrumbs->push(trans('cortex/pages::common.create_page'), route('managerarea.cortex.pages.pages.create'));
});

Breadcrumbs::register('managerarea.cortex.pages.pages.edit', function (BreadcrumbsGenerator $breadcrumbs, Page $page) {
    $breadcrumbs->parent('managerarea.cortex.pages.pages.index');
    $breadcrumbs->push(strip_tags($page->title), route('managerarea.cortex.pages.pages.edit', ['page' => $page]));
});

Breadcrumbs::register('managerarea.cortex.pages.pages.logs', function (BreadcrumbsGenerator $breadcrumbs, Page $page) {
    $breadcrumbs->parent('managerarea.cortex.pages.pages.index');
    $breadcrumbs->push(strip_tags($page->title), route('managerarea.cortex.pages.pages.edit', ['page' => $page]));
    $breadcrumbs->push(trans('cortex/pages::common.logs'), route('managerarea.cortex.pages.pages.logs', ['page' => $page]));
});

Breadcrumbs::register('managerarea.cortex.pages.pages.media.index', function (BreadcrumbsGenerator $breadcrumbs, Page $page) {
    $breadcrumbs->parent('managerarea.cortex.pages.pages.index');
    $breadcrumbs->push(strip_tags($page->title), route('managerarea.cortex.pages.pages.edit', ['page' => $page]));
    $breadcrumbs->push(trans('cortex/pages::common.media'), route('managerarea.cortex.pages.pages.media.index', ['page' => $page]));
});
