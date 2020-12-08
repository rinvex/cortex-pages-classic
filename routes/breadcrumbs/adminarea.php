<?php

declare(strict_types=1);

use Cortex\Pages\Models\Page;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('adminarea.cortex.pages.pages.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('app.name'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/pages::common.pages'), route('adminarea.cortex.pages.pages.index'));
});

Breadcrumbs::register('adminarea.cortex.pages.pages.import', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.pages.pages.index');
    $breadcrumbs->push(trans('cortex/pages::common.import'), route('adminarea.cortex.pages.pages.import'));
});

Breadcrumbs::register('adminarea.cortex.pages.pages.import.logs', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.pages.pages.index');
    $breadcrumbs->push(trans('cortex/pages::common.import'), route('adminarea.cortex.pages.pages.import'));
    $breadcrumbs->push(trans('cortex/pages::common.logs'), route('adminarea.cortex.pages.pages.import.logs'));
});

Breadcrumbs::register('adminarea.cortex.pages.pages.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.pages.pages.index');
    $breadcrumbs->push(trans('cortex/pages::common.create_page'), route('adminarea.cortex.pages.pages.create'));
});

Breadcrumbs::register('adminarea.cortex.pages.pages.edit', function (BreadcrumbsGenerator $breadcrumbs, Page $page) {
    $breadcrumbs->parent('adminarea.cortex.pages.pages.index');
    $breadcrumbs->push(strip_tags($page->title), route('adminarea.cortex.pages.pages.edit', ['page' => $page]));
});

Breadcrumbs::register('adminarea.cortex.pages.pages.logs', function (BreadcrumbsGenerator $breadcrumbs, Page $page) {
    $breadcrumbs->parent('adminarea.cortex.pages.pages.index');
    $breadcrumbs->push(strip_tags($page->title), route('adminarea.cortex.pages.pages.edit', ['page' => $page]));
    $breadcrumbs->push(trans('cortex/pages::common.logs'), route('adminarea.cortex.pages.pages.logs', ['page' => $page]));
});

Breadcrumbs::register('adminarea.cortex.pages.pages.media.index', function (BreadcrumbsGenerator $breadcrumbs, Page $page) {
    $breadcrumbs->parent('adminarea.cortex.pages.pages.index');
    $breadcrumbs->push(strip_tags($page->title), route('adminarea.cortex.pages.pages.edit', ['page' => $page]));
    $breadcrumbs->push(trans('cortex/pages::common.media'), route('adminarea.cortex.pages.pages.media.index', ['page' => $page]));
});
