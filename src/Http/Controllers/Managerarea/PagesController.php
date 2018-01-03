<?php

declare(strict_types=1);

namespace Cortex\Pages\Http\Controllers\Managerarea;

use Illuminate\Http\Request;
use Rinvex\Pages\Contracts\PageContract;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Pages\DataTables\Managerarea\PagesDataTable;
use Cortex\Pages\Http\Requests\Managerarea\PageFormRequest;
use Cortex\Foundation\Http\Controllers\AuthorizedController;

class PagesController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'pages';

    /**
     * Display a listing of the resource.
     *
     * @param \Cortex\Pages\DataTables\Managerarea\PagesDataTable $pagesDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(PagesDataTable $pagesDataTable)
    {
        return $pagesDataTable->with([
            'id' => 'cortex-pages',
            'phrase' => trans('cortex/pages::common.pages'),
        ])->render('cortex/tenants::managerarea.pages.datatable');
    }

    /**
     * Get a listing of the resource logs.
     *
     * @param \Rinvex\Pages\Contracts\PageContract $page
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logs(PageContract $page)
    {
        return request()->ajax() && request()->wantsJson()
            ? app(LogsDataTable::class)->with(['resource' => $page])->ajax()
            : intend(['url' => route('adminarea.pages.edit', ['page' => $page]).'#logs-tab']);
    }

    /**
     * Show the form for create/update of the given resource.
     *
     * @param \Rinvex\Pages\Contracts\PageContract $page
     *
     * @return \Illuminate\Http\Response
     */
    public function form(PageContract $page)
    {
        $logs = app(LogsDataTable::class)->with(['id' => 'logs-table'])->html()->minifiedAjax(route('managerarea.pages.logs', ['page' => $page]));

        return view('cortex/pages::managerarea.pages.page', compact('page', 'logs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Cortex\Pages\Http\Requests\Managerarea\PageFormRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PageFormRequest $request)
    {
        return $this->process($request, app('rinvex.pages.page'));
    }

    /**
     * Update the given resource in storage.
     *
     * @param \Cortex\Pages\Http\Requests\Managerarea\PageFormRequest $request
     * @param \Rinvex\Pages\Contracts\PageContract                    $page
     *
     * @return \Illuminate\Http\Response
     */
    public function update(PageFormRequest $request, PageContract $page)
    {
        return $this->process($request, $page);
    }

    /**
     * Process the form for store/update of the given resource.
     *
     * @param \Illuminate\Http\Request             $request
     * @param \Rinvex\Pages\Contracts\PageContract $page
     *
     * @return \Illuminate\Http\Response
     */
    protected function process(Request $request, PageContract $page)
    {
        // Prepare required input fields
        $data = $request->all();

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
            'with' => ['success' => trans('cortex/pages::messages.page.saved', ['slug' => $page->slug])],
        ]);
    }

    /**
     * Delete the given resource from storage.
     *
     * @param \Rinvex\Pages\Contracts\PageContract $page
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(PageContract $page)
    {
        $page->delete();

        return intend([
            'url' => route('managerarea.pages.index'),
            'with' => ['warning' => trans('cortex/pages::messages.page.deleted', ['slug' => $page->slug])],
        ]);
    }
}
