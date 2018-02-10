<?php

declare(strict_types=1);

namespace Cortex\Pages\Http\Controllers\Managerarea;

use Rinvex\Pages\Models\Page;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Pages\DataTables\Managerarea\PagesDataTable;
use Cortex\Pages\Http\Requests\Managerarea\PageFormRequest;
use Cortex\Foundation\Http\Controllers\AuthorizedController;

class PagesController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'page';

    /**
     * List all pages.
     *
     * @param \Cortex\Pages\DataTables\Managerarea\PagesDataTable $pagesDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(PagesDataTable $pagesDataTable)
    {
        return $pagesDataTable->with([
            'id' => 'managerarea-pages-index-table',
            'phrase' => trans('cortex/pages::common.pages'),
        ])->render('cortex/tenants::managerarea.pages.datatable');
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
            'tabs' => 'managerarea.pages.tabs',
            'phrase' => trans('cortex/pages::common.pages'),
            'id' => "managerarea-pages-{$page->getKey()}-logs-table",
        ])->render('cortex/tenants::managerarea.pages.datatable-logs');
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
        return view('cortex/pages::managerarea.pages.page', compact('page'));
    }

    /**
     * Store new page.
     *
     * @param \Cortex\Pages\Http\Requests\Managerarea\PageFormRequest $request
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
     * @param \Cortex\Pages\Http\Requests\Managerarea\PageFormRequest $request
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

        // Save page
        $page->fill($data)->save();

        return intend([
            'url' => route('managerarea.pages.index'),
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
            'url' => route('managerarea.pages.index'),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => 'page', 'id' => $page->slug])],
        ]);
    }
}
