<?php

declare(strict_types=1);

namespace Cortex\Pages\DataTables\Backend;

use Cortex\Foundation\DataTables\AbstractDataTable;
use Cortex\Pages\Transformers\Backend\PageTransformer;

class PagesDataTable extends AbstractDataTable
{
    /**
     * {@inheritdoc}
     */
    protected $model = 'rinvex.pages.page';

    /**
     * {@inheritdoc}
     */
    protected $transformer = PageTransformer::class;

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
     * Get parameters.
     *
     * @return array
     */
    protected function getParameters()
    {
        return [
            'keys' => true,
            'autoWidth' => false,
            'dom' => "<'row'<'col-sm-6'B><'col-sm-6'f>> <'row'r><'row'<'col-sm-12't>> <'row'<'col-sm-5'i><'col-sm-7'p>>",
            'buttons' => [
                ['extend' => 'create', 'text' => '<i class="fa fa-plus"></i> '.trans('cortex/foundation::common.new')], 'print', 'reset', 'reload', 'export',
                ['extend' => 'colvis', 'text' => '<i class="fa fa-columns"></i> '.trans('cortex/foundation::common.columns').' <span class="caret"/>'],
            ],
        ];
    }

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->setTransformer(new $this->transformer())
            ->orderColumn('title', 'title->"$.'.app()->getLocale().'" $1')
            ->make(true);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'title' => ['title' => trans('cortex/pages::common.title'), 'render' => '"<a href=\""+routes.route(\'backend.pages.edit\', {page: full.id})+"\">"+data+"</a>"', 'responsivePriority' => 0],
            'uri' => ['title' => trans('cortex/pages::common.uri')],
            'view' => ['title' => trans('cortex/pages::common.view')],
            'middleware' => ['title' => trans('cortex/pages::common.middleware')],
            'created_at' => ['title' => trans('cortex/pages::common.created_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
            'updated_at' => ['title' => trans('cortex/pages::common.updated_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
        ];
    }
}
