<?php

declare(strict_types=1);

use Cortex\Pages\Models\Page;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('adminarea.pages.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('app.name'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/pages::common.pages'), route('adminarea.pages.index'));
});

Breadcrumbs::register('adminarea.pages.import', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.pages.index');
    $breadcrumbs->push(trans('cortex/pages::common.import'), route('adminarea.pages.import'));
});

Breadcrumbs::register('adminarea.pages.import.logs', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.pages.index');
    $breadcrumbs->push(trans('cortex/pages::common.import'), route('adminarea.pages.import'));
    $breadcrumbs->push(trans('cortex/pages::common.logs'), route('adminarea.pages.import.logs'));
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
