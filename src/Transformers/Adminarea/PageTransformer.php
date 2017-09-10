<?php

declare(strict_types=1);

namespace Cortex\Pages\Transformers\Adminarea;

use League\Fractal\TransformerAbstract;
use Rinvex\Pages\Contracts\PageContract;

class PageTransformer extends TransformerAbstract
{
    /**
     * @return array
     */
    public function transform(PageContract $page)
    {
        return [
            'id' => (int) $page->id,
            'uri' => (string) $page->uri === '/' ? '/' : '/'.$page->uri,
            'view' => (string) $page->view,
            'slug' => (string) $page->slug,
            'route' => (string) $page->route,
            'title' => (string) $page->title,
            'middleware' => (string) $page->middleware,
            'created_at' => (string) $page->created_at,
            'updated_at' => (string) $page->updated_at,
        ];
    }
}
