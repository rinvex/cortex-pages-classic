<?php

declare(strict_types=1);

namespace Cortex\Pages\Transformers\Adminarea;

use League\Fractal\TransformerAbstract;
use Rinvex\Pages\Models\Page;

class PageTransformer extends TransformerAbstract
{
    /**
     * @return array
     */
    public function transform(Page $page): array
    {
        return [
            'id' => (int) $page->getKey(),
            'uri' => (string) $page->uri === '/' ? '/' : '/'.$page->uri,
            'view' => (string) $page->view,
            'slug' => (string) $page->slug,
            'route' => (string) $page->route,
            'title' => (string) $page->title,
            'domain' => (string) $page->domain,
            'is_active' => (bool) $page->is_active,
            'sort_order' => (string) $page->sort_order,
            'middleware' => (string) $page->middleware,
            'created_at' => (string) $page->created_at,
            'updated_at' => (string) $page->updated_at,
        ];
    }
}
