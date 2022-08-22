<?php

declare(strict_types=1);

use Cortex\Pages\Models\Page;
use Diglactic\Breadcrumbs\Generator;
use Diglactic\Breadcrumbs\Breadcrumbs;

Breadcrumbs::for('managerarea.cortex.pages.pages.index', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.home');
    $breadcrumbs->push(trans('cortex/pages::common.pages'), route('managerarea.cortex.pages.pages.index'));
});

Breadcrumbs::for('managerarea.cortex.pages.pages.import', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.cortex.pages.pages.index');
    $breadcrumbs->push(trans('cortex/pages::common.import'), route('managerarea.cortex.pages.pages.import'));
});

Breadcrumbs::for('managerarea.cortex.pages.pages.import.logs', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.cortex.pages.pages.import');
    $breadcrumbs->push(trans('cortex/pages::common.logs'), route('managerarea.cortex.pages.pages.import.logs'));
});

Breadcrumbs::for('managerarea.cortex.pages.pages.create', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.cortex.pages.pages.index');
    $breadcrumbs->push(trans('cortex/pages::common.create_page'), route('managerarea.cortex.pages.pages.create'));
});

Breadcrumbs::for('managerarea.cortex.pages.pages.edit', function (Generator $breadcrumbs, Page $page) {
    $breadcrumbs->parent('managerarea.cortex.pages.pages.index');
    $breadcrumbs->push(strip_tags($page->title), route('managerarea.cortex.pages.pages.edit', ['page' => $page]));
});

Breadcrumbs::for('managerarea.cortex.pages.pages.logs', function (Generator $breadcrumbs, Page $page) {
    $breadcrumbs->parent('managerarea.cortex.pages.pages.edit', $page);
    $breadcrumbs->push(trans('cortex/pages::common.logs'), route('managerarea.cortex.pages.pages.logs', ['page' => $page]));
});

Breadcrumbs::for('managerarea.cortex.pages.pages.media.index', function (Generator $breadcrumbs, Page $page) {
    $breadcrumbs->parent('managerarea.cortex.pages.pages.edit', $page);
    $breadcrumbs->push(trans('cortex/pages::common.media'), route('managerarea.cortex.pages.pages.media.index', ['page' => $page]));
});
