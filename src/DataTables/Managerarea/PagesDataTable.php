<?php

declare(strict_types=1);

namespace Cortex\Pages\DataTables\Managerarea;

use Cortex\Pages\Models\Page;
use Illuminate\Http\JsonResponse;
use Cortex\Pages\Transformers\PageTransformer;
use Cortex\Foundation\DataTables\AbstractDataTable;

class PagesDataTable extends AbstractDataTable
{
    /**
     * {@inheritdoc}
     */
    protected $model = Page::class;

    /**
     * {@inheritdoc}
     */
    protected $transformer = PageTransformer::class;

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax(): JsonResponse
    {
        return datatables($this->query())
            ->setTransformer(app($this->transformer))
            ->orderColumn('name', 'name->"$.'.app()->getLocale().'" $1')
            ->whitelist(array_keys($this->getColumns()))
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
            ? '"<a href=\""+routes.route(\'managerarea.cortex.pages.pages.edit\', {page: full.id, locale: \''.$this->request()->segment(1).'\'})+"\">"+data+"</a>"'
            : '"<a href=\""+routes.route(\'managerarea.cortex.pages.pages.edit\', {page: full.id})+"\">"+data+"</a>"';

        return [
            'id' => ['checkboxes' => json_decode('{"selectRow": true}'), 'exportable' => false, 'printable' => false],
            'title' => ['title' => trans('cortex/pages::common.title'), 'render' => $link.'+(full.is_active ? " <i class=\"text-success fa fa-check\"></i>" : " <i class=\"text-danger fa fa-close\"></i>")', 'responsivePriority' => 0],
            'uri' => ['title' => trans('cortex/pages::common.uri')],
            'domain' => ['title' => trans('cortex/pages::common.domain'), 'visible' => false],
            'route' => ['title' => trans('cortex/pages::common.route')],
            'view' => ['title' => trans('cortex/pages::common.view'), 'visible' => false],
            'middleware' => ['title' => trans('cortex/pages::common.middleware'), 'visible' => false],
            'sort_order' => ['title' => trans('cortex/pages::common.sort_order'), 'visible' => false],
            'created_at' => ['title' => trans('cortex/pages::common.created_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
            'updated_at' => ['title' => trans('cortex/pages::common.updated_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
        ];
    }
}
