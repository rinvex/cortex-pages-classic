<?php

declare(strict_types=1);

namespace Cortex\Pages\DataTables\Adminarea;

use Cortex\Pages\Models\Page;
use Cortex\Foundation\DataTables\AbstractDataTable;

class PagesDataTable extends AbstractDataTable
{
    /**
     * {@inheritdoc}
     */
    protected $model = Page::class;

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $locale = app()->getLocale();
        $query = app($this->model)->query()->orderBy('sort_order', 'ASC')->orderBy("title->\${$locale}", 'ASC');

        return $this->applyScopes($query);
    }

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return datatables($this->query())
            ->orderColumn('title', 'title->"$.'.app()->getLocale().'" $1')
            ->make(true);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        $link = config('cortex.foundation.route.locale_prefix')
            ? '"<a href=\""+routes.route(\'adminarea.pages.edit\', {page: hashids.encode(full.id), locale: \''.$this->request->segment(1).'\'})+"\">"+data+"</a>"'
            : '"<a href=\""+routes.route(\'adminarea.pages.edit\', {page: hashids.encode(full.id)})+"\">"+data+"</a>"';

        return [
            'title' => ['title' => trans('cortex/pages::common.title'), 'render' => $link.'+(full.is_active ? " <i class=\"text-success fa fa-check\"></i>" : " <i class=\"text-danger fa fa-close\"></i>")', 'responsivePriority' => 0],
            'uri' => ['title' => trans('cortex/pages::common.uri')],
            'domain' => ['title' => trans('cortex/pages::common.domain'), 'visible' => false],
            'route' => ['title' => trans('cortex/pages::common.route')],
            'view' => ['title' => trans('cortex/pages::common.view'), 'visible' => false],
            'middleware' => ['title' => trans('cortex/pages::common.middleware'), 'visible' => false],
            'sort_order' => ['title' => trans('cortex/pages::common.sort_order'), 'visible' => false],
            'created_at' => ['title' => trans('cortex/pages::common.created_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
            'updated_at' => ['title' => trans('cortex/pages::common.updated_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
        ];
    }
}
