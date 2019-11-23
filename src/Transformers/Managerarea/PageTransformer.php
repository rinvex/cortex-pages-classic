<?php

declare(strict_types=1);

namespace Cortex\Pages\Transformers\Managerarea;

use Cortex\Pages\Models\Page;
use Rinvex\Support\Traits\Escaper;
use League\Fractal\TransformerAbstract;

class PageTransformer extends TransformerAbstract
{
    use Escaper;

    /**
     * @return array
     */
    public function transform(Page $page): array
    {
        return $this->escape([
            'id' => (string) $page->getRouteKey(),
            'DT_RowId' => 'row_'.$page->getRouteKey(),
            'title' => (string) $page->title,
            'uri' => (string) $page->uri,
            'domain' => (string) $page->domain,
            'route' => (string) $page->route,
            'view' => (string) $page->view,
            'middleware' => (string) $page->middleware,
            'sort_order' => (string) $page->sort_order,
            'created_at' => (string) $page->created_at,
            'updated_at' => (string) $page->updated_at,
        ]);
    }
}
