<?php

declare(strict_types=1);

namespace Cortex\Pages\Transformers\Backend;

use Rinvex\Pages\Contracts\PageContract;
use League\Fractal\TransformerAbstract;

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
            'title' => (string) $page->title,
            'middleware' => (string) $page->middleware,
            'created_at' => (string) $page->created_at,
            'updated_at' => (string) $page->updated_at,
        ];
    }
}
