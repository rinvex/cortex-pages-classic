<?php

declare(strict_types=1);

namespace Cortex\Pages\Http\Controllers\Adminarea;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Cortex\Pages\Models\Page;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Foundation\Importers\DefaultImporter;
use Cortex\Foundation\DataTables\ImportLogsDataTable;
use Cortex\Pages\DataTables\Adminarea\PagesDataTable;
use Cortex\Foundation\Http\Requests\ImportFormRequest;
use Cortex\Foundation\DataTables\ImportRecordsDataTable;
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
            'id' => 'adminarea-cortex-pages-pages-index',
            'pusher' => ['entity' => 'page', 'channel' => 'cortex.pages.pages.index'],
        ])->render('cortex/foundation::adminarea.pages.datatable-index');
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
            'tabs' => 'adminarea.cortex.pages.pages.tabs',
            'id' => "adminarea-cortex-pages-pages-{$page->getRouteKey()}-logs",
        ])->render('cortex/foundation::adminarea.pages.datatable-tab');
    }

    /**
     * Import pages.
     *
     * @param \Cortex\Pages\Models\Page                            $page
     * @param \Cortex\Foundation\DataTables\ImportRecordsDataTable $importRecordsDataTable
     *
     * @return \Illuminate\View\View
     */
    public function import(Page $page, ImportRecordsDataTable $importRecordsDataTable)
    {
        return $importRecordsDataTable->with([
            'resource' => $page,
            'tabs' => 'adminarea.cortex.pages.pages.tabs',
            'url' => route('adminarea.cortex.pages.pages.stash'),
            'id' => "adminarea-cortex-pages-pages-{$page->getRouteKey()}-import",
        ])->render('cortex/foundation::adminarea.pages.datatable-dropzone');
    }

    /**
     * Stash pages.
     *
     * @param \Cortex\Foundation\Http\Requests\ImportFormRequest $request
     * @param \Cortex\Foundation\Importers\DefaultImporter       $importer
     *
     * @return void
     */
    public function stash(ImportFormRequest $request, DefaultImporter $importer)
    {
        // Handle the import
        $importer->config['resource'] = $this->resource;
        $importer->handleImport();
    }

    /**
     * Hoard pages.
     *
     * @param \Cortex\Foundation\Http\Requests\ImportFormRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function hoard(ImportFormRequest $request)
    {
        foreach ((array) $request->get('selected_ids') as $recordId) {
            $record = app('cortex.foundation.import_record')->find($recordId);

            try {
                $fillable = collect($record['data'])->intersectByKeys(array_flip(app('rinvex.pages.page')->getFillable()))->toArray();

                tap(app('rinvex.pages.page')->firstOrNew($fillable), function ($instance) use ($record) {
                    $instance->save() && $record->delete();
                });
            } catch (Exception $exception) {
                $record->notes = $exception->getMessage().(method_exists($exception, 'getMessageBag') ? "\n".json_encode($exception->getMessageBag())."\n\n" : '');
                $record->status = 'fail';
                $record->save();
            }
        }

        return intend([
            'back' => true,
            'with' => ['success' => trans('cortex/foundation::messages.import_complete')],
        ]);
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
            'resource' => trans('cortex/pages::common.page'),
            'tabs' => 'adminarea.cortex.pages.pages.tabs',
            'id' => 'adminarea-cortex-pages-pages-import-logs',
        ])->render('cortex/foundation::adminarea.pages.datatable-tab');
    }

    /**
     * Create new page.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \Cortex\Pages\Models\Page $page
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request, Page $page)
    {
        return $this->form($request, $page);
    }

    /**
     * Edit given page.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \Cortex\Pages\Models\Page $page
     *
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, Page $page)
    {
        return $this->form($request, $page);
    }

    /**
     * Show page create/edit form.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \Cortex\Pages\Models\Page $page
     *
     * @return \Illuminate\View\View
     */
    protected function form(Request $request, Page $page)
    {
        if (! $page->exists && $request->has('replicate') && $replicated = $page->resolveRouteBinding($request->get('replicate'))) {
            $page = $replicated->replicate();
        }

        $pageables = collect();
        $tags = app('rinvex.tags.tag')->pluck('name', 'id');
        $tenants = app('rinvex.tenants.tenant')->all()->pluck('name', 'id');

        app('rinvex.pages.pageables')->each(function ($pageable, $key) use ($pageables, $page) {
            $page->load(Str::plural($key));
            $pageables->put($key, app($pageable)->all()->pluck('name', 'id'));
        });

        return view('cortex/pages::adminarea.pages.page', compact('page', 'tags', 'tenants', 'pageables'));
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
                  ->toMediaCollection('profile_picture', config('cortex.foundation.media.disk'));

        ! $request->hasFile('cover_photo')
        || $page->addMediaFromRequest('cover_photo')
                  ->sanitizingFileName(function ($fileName) {
                      return md5($fileName).'.'.pathinfo($fileName, PATHINFO_EXTENSION);
                  })
                  ->toMediaCollection('cover_photo', config('cortex.foundation.media.disk'));

        // Save page
        $page->fill($data)->save();

        return intend([
            'url' => route('adminarea.cortex.pages.pages.index'),
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => trans('cortex/pages::common.page'), 'identifier' => $page->getRouteKey()])],
        ]);
    }

    /**
     * Destroy given page.
     *
     * @param \Cortex\Pages\Models\Page $page
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Page $page)
    {
        $page->delete();

        return intend([
            'url' => route('adminarea.cortex.pages.pages.index'),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => trans('cortex/pages::common.page'), 'identifier' => $page->getRouteKey()])],
        ]);
    }
}
