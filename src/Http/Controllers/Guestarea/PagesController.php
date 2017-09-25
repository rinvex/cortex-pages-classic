<?php

declare(strict_types=1);

namespace Cortex\Pages\Http\Controllers\Guestarea;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PagesController extends Controller
{
    public function __invoke(Request $request)
    {
        $route = $request->route()->uri() === '{locale}' ? '/' : $request->route()->uri().'/';

        $page = app('rinvex.pages.page')->where('uri', $route)->where('domain', $request->route()->domain())->first();

        return view($page->view, compact('page'));
    }
}
