<?php

declare(strict_types=1);

namespace Cortex\Pages\Http\Controllers\Frontarea;

use Illuminate\Http\Request;
use Cortex\Foundation\Http\Controllers\AbstractController;

class PagesController extends AbstractController
{
    public function __invoke(Request $request)
    {
        $uri = trim(str_replace('{locale}', '', $request->route()->uri()), " \t\n\r\0\x0B/") ?: '/';

        $page = app('rinvex.pages.page')->where('uri', $uri)->where('domain', $request->route()->domain() ?: null)->first();

        return view($page->view, compact('page'));
    }
}
