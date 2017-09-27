<?php

declare(strict_types=1);

namespace Cortex\Pages\Http\Controllers\Guestarea;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PagesController extends Controller
{
    public function __invoke(Request $request)
    {
        $uri = trim(str_replace('{locale}', '', $request->route()->uri()), " \t\n\r\0\x0B/") ?: '/';

        $page = app('rinvex.pages.page')->where('uri', $uri)->where('domain', $request->route()->domain())->first();

        return view($page->view, compact('page'));
    }
}
