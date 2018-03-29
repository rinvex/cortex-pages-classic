<?php

declare(strict_types=1);

namespace Cortex\Pages\Http\Controllers\Adminarea;

use Cortex\Pages\Models\Page;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Foundation\Importers\DefaultImporter;
use Cortex\Foundation\DataTables\ImportLogsDataTable;
use Cortex\Pages\DataTables\Adminarea\PagesDataTable;
use Cortex\Foundation\Http\Requests\ImportFormRequest;
use Cortex\Pages\Http\Requests\Adminarea\PageFormRequest;
use Cortex\Foundation\Http\Controllers\AuthorizedController;

class PagesController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = Page::class;

    /**
     * List all pages.
     *
     * @param \Cortex\Pages\DataTables\Adminarea\PagesDataTable $pagesDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(PagesDataTable $pagesDataTable)
    {
        return $pagesDataTable->with([
            'id' => 'adminarea-pages-index-table',
            'phrase' => trans('cortex/pages::common.pages'),
        ])->render('cortex/foundation::adminarea.pages.datatable');
    }

    /**
     * List page logs.
     *
     * @param \Cortex\Pages\Models\Page                   $page
     * @param \Cortex\Foundation\DataTables\LogsDataTable $logsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function logs(Page $page, LogsDataTable $logsDataTable)
    {
        return $logsDataTable->with([
            'resource' => $page,
            'tabs' => 'adminarea.pages.tabs',
            'phrase' => trans('cortex/pages::common.pages'),
            'id' => "adminarea-pages-{$page->getRouteKey()}-logs-table",
        ])->render('cortex/foundation::adminarea.pages.datatable-logs');
    }

    /**
     * Import pages.
     *
     * @return \Illuminate\View\View
     */
    public function import()
    {
        return view('cortex/foundation::adminarea.pages.import', [
            'id' => 'adminarea-pages-import',
            'tabs' => 'adminarea.pages.tabs',
            'url' => route('adminarea.pages.hoard'),
            'phrase' => trans('cortex/pages::common.pages'),
        ]);
    }

    /**
     * Hoard pages.
     *
     * @param \Cortex\Foundation\Http\Requests\ImportFormRequest $request
     * @param \Cortex\Foundation\Importers\DefaultImporter       $importer
     *
     * @return void
     */
    public function hoard(ImportFormRequest $request, DefaultImporter $importer)
    {
        // Handle the import
        $importer->config['resource'] = $this->resource;
        $importer->handleImport();
    }

    /**
     * List page import logs.
     *
     * @param \Cortex\Foundation\DataTables\ImportLogsDataTable $importLogsDatatable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function importLogs(ImportLogsDataTable $importLogsDatatable)
    {
        return $importLogsDatatable->with([
            'resource' => 'page',
            'tabs' => 'adminarea.pages.tabs',
            'id' => 'adminarea-pages-import-logs-table',
            'phrase' => trans('cortex/pages::common.pages'),
        ])->render('cortex/foundation::adminarea.pages.datatable-import-logs');
    }

    /**
     * Create new page.
     *
     * @param \Cortex\Pages\Models\Page $page
     *
     * @return \Illuminate\View\View
     */
    public function create(Page $page)
    {
        return $this->form($page);
    }

    /**
     * Edit given page.
     *
     * @param \Cortex\Pages\Models\Page $page
     *
     * @return \Illuminate\View\View
     */
    public function edit(Page $page)
    {
        return $this->form($page);
    }

    /**
     * Show page create/edit form.
     *
     * @param \Cortex\Pages\Models\Page $page
     *
     * @return \Illuminate\View\View
     */
    protected function form(Page $page)
    {
        $tags = app('rinvex.tags.tag')->pluck('name', 'id');

        return view('cortex/pages::adminarea.pages.page', compact('page', 'tags'));
    }

    /**
     * Store new page.
     *
     * @param \Cortex\Pages\Http\Requests\Adminarea\PageFormRequest $request
     * @param \Cortex\Pages\Models\Page                             $page
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(PageFormRequest $request, Page $page)
    {
        return $this->process($request, $page);
    }

    /**
     * Update given page.
     *
     * @param \Cortex\Pages\Http\Requests\Adminarea\PageFormRequest $request
     * @param \Cortex\Pages\Models\Page                             $page
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(PageFormRequest $request, Page $page)
    {
        return $this->process($request, $page);
    }

    /**
     * Process stored/updated page.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \Cortex\Pages\Models\Page               $page
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function process(FormRequest $request, Page $page)
    {
        // Prepare required input fields
        $data = $request->validated();

        // Verify existing view
        if (! view()->exists($data['view'])) {
            return intend([
                'back' => true,
                'withInput' => $request->all(),
                'withErrors' => ['view' => trans('cortex/pages::messages.page.invalid_view')],
            ]);
        }

        ! $request->hasFile('profile_picture')
        || $page->addMediaFromRequest('profile_picture')
                  ->sanitizingFileName(function ($fileName) {
                      return md5($fileName).'.'.pathinfo($fileName, PATHINFO_EXTENSION);
                  })
                  ->toMediaCollection('profile_picture', config('cortex.auth.media.disk'));

        ! $request->hasFile('cover_photo')
        || $page->addMediaFromRequest('cover_photo')
                  ->sanitizingFileName(function ($fileName) {
                      return md5($fileName).'.'.pathinfo($fileName, PATHINFO_EXTENSION);
                  })
                  ->toMediaCollection('cover_photo', config('cortex.auth.media.disk'));

        // Save page
        $page->fill($data)->save();

        return intend([
            'url' => route('adminarea.pages.index'),
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => 'page', 'id' => $page->slug])],
        ]);
    }

    /**
     * Destroy given page.
     *
     * @param \Cortex\Pages\Models\Page $page
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Page $page)
    {
        $page->delete();

        return intend([
            'url' => route('adminarea.pages.index'),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => 'page', 'id' => $page->slug])],
        ]);
    }
}
