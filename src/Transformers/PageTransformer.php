<?php

declare(strict_types=1);

namespace Cortex\Pages\Transformers;

use Cortex\Pages\Models\Page;
use Rinvex\Support\Traits\Escaper;
use League\Fractal\TransformerAbstract;

class PageTransformer extends TransformerAbstract
{
    use Escaper;

    /**
     * Transform page model.
     *
     * @param \Cortex\Pages\Models\Page $page
     *
     * @throws \Exception
     *
     * @return array
     */
    public function transform(Page $page): array
    {
        return $this->escape([
            'id' => (string) $page->getRouteKey(),
            'uri' => (string) $page->uri,
            'slug' => (string) $page->slug,
            'route' => (string) $page->route,
            'domain' => (string) $page->domain,
            'middleware' => (string) $page->middleware,
            'title' => (string) $page->title,
            'view' => (string) $page->view,
            'sort_order' => (string) $page->sort_order,
            'created_at' => (string) $page->created_at,
            'updated_at' => (string) $page->updated_at,
        ]);
    }
}
