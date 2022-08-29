<?php

declare(strict_types=1);

use Cortex\Pages\Models\Page;
use Diglactic\Breadcrumbs\Generator;
use Diglactic\Breadcrumbs\Breadcrumbs;

Breadcrumbs::for('adminarea.cortex.pages.pages.index', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.home');
    $breadcrumbs->push(trans('cortex/pages::common.pages'), route('adminarea.cortex.pages.pages.index'));
});

Breadcrumbs::for('adminarea.cortex.pages.pages.import', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.pages.pages.index');
    $breadcrumbs->push(trans('cortex/pages::common.import'), route('adminarea.cortex.pages.pages.import'));
});

Breadcrumbs::for('adminarea.cortex.pages.pages.import.logs', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.pages.pages.import');
    $breadcrumbs->push(trans('cortex/pages::common.logs'), route('adminarea.cortex.pages.pages.import.logs'));
});

Breadcrumbs::for('adminarea.cortex.pages.pages.create', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.pages.pages.index');
    $breadcrumbs->push(trans('cortex/pages::common.create_page'), route('adminarea.cortex.pages.pages.create'));
});

Breadcrumbs::for('adminarea.cortex.pages.pages.edit', function (Generator $breadcrumbs, Page $page) {
    $breadcrumbs->parent('adminarea.cortex.pages.pages.index');
    $breadcrumbs->push(strip_tags($page->title), route('adminarea.cortex.pages.pages.edit', ['page' => $page]));
});

Breadcrumbs::for('adminarea.cortex.pages.pages.logs', function (Generator $breadcrumbs, Page $page) {
    $breadcrumbs->parent('adminarea.cortex.pages.pages.edit', $page);
    $breadcrumbs->push(trans('cortex/pages::common.logs'), route('adminarea.cortex.pages.pages.logs', ['page' => $page]));
});

Breadcrumbs::for('adminarea.cortex.pages.pages.media.index', function (Generator $breadcrumbs, Page $page) {
    $breadcrumbs->parent('adminarea.cortex.pages.pages.edit', $page);
    $breadcrumbs->push(trans('cortex/pages::common.media'), route('adminarea.cortex.pages.pages.media.index', ['page' => $page]));
});
