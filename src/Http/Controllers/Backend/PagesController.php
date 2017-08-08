<?php

declare(strict_types=1);

namespace Cortex\Pages\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Cortex\Pages\Models\Page;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Pages\DataTables\Backend\PagesDataTable;
use Cortex\Pages\Http\Requests\Backend\PageFormRequest;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return app(PagesDataTable::class)->with([
            'id' => 'cortex-pages-pages',
            'phrase' => trans('cortex/pages::common.pages'),
        ])->render('cortex/foundation::backend.partials.datatable');
    }

    /**
     * Display a listing of the resource logs.
     *
     * @return \Illuminate\Http\Response
     */
    public function logs(Page $page)
    {
        return app(LogsDataTable::class)->with([
            'type' => 'pages',
            'resource' => $page,
            'id' => 'cortex-pages-pages-logs',
            'phrase' => trans('cortex/pages::common.pages'),
        ])->render('cortex/foundation::backend.partials.datatable-logs');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Cortex\Pages\Http\Requests\Backend\PageFormRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PageFormRequest $request)
    {
        return $this->process($request, new Page());
    }

    /**
     * Update the given resource in storage.
     *
     * @param \Cortex\Pages\Http\Requests\Backend\PageFormRequest $request
     * @param \Cortex\Pages\Models\Page                           $page
     *
     * @return \Illuminate\Http\Response
     */
    public function update(PageFormRequest $request, Page $page)
    {
        return $this->process($request, $page);
    }

    /**
     * Delete the given resource from storage.
     *
     * @param \Cortex\Pages\Models\Page $page
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Page $page)
    {
        $page->delete();

        return intend([
            'url' => route('backend.pages.index'),
            'with' => ['warning' => trans('cortex/pages::messages.page.deleted', ['pageId' => $page->id])],
        ]);
    }

    /**
     * Show the form for create/update of the given resource.
     *
     * @param \Cortex\Pages\Models\Page $page
     *
     * @return \Illuminate\Http\Response
     */
    public function form(Page $page)
    {
        return view('cortex/pages::backend.forms.page', compact('page'));
    }

    /**
     * Process the form for store/update of the given resource.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \Cortex\Pages\Models\Page $page
     *
     * @return \Illuminate\Http\Response
     */
    protected function process(Request $request, Page $page)
    {
        // Prepare required input fields
        $data = $request->all();

        // Save page
        $page->fill($data)->save();

        return intend([
            'url' => route('backend.pages.index'),
            'with' => ['success' => trans('cortex/pages::messages.page.saved', ['pageId' => $page->id])],
        ]);
    }
}
