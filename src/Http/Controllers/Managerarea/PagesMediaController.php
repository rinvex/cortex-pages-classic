<?php

declare(strict_types=1);

namespace Cortex\Pages\Http\Controllers\Managerarea;

use Spatie\MediaLibrary\Models\Media;
use Rinvex\Pages\Contracts\PageContract;
use Cortex\Foundation\DataTables\MediaDataTable;
use Cortex\Foundation\Http\Requests\ImageFormRequest;
use Cortex\Foundation\Http\Controllers\AuthorizedController;

class PagesMediaController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'pages';

    /**
     * {@inheritdoc}
     */
    protected $resourceAbilityMap = [
        'index' => 'list-media',
        'store' => 'create-media',
        'delete' => 'delete-media',
    ];

    /**
     * Get a listing of the resource media.
     *
     * @param \Rinvex\Pages\Contracts\PageContract $page
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function index(PageContract $page)
    {
        return request()->ajax() && request()->wantsJson()
            ? app(MediaDataTable::class)->with(['resource' => $page])->ajax()
            : intend(['url' => route('managerarea.pages.edit', ['page' => $page]).'#media-tab']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Cortex\Foundation\Http\Requests\ImageFormRequest $request
     * @param \Rinvex\Pages\Contracts\PageContract              $page
     *
     * @return void
     */
    public function store(ImageFormRequest $request, PageContract $page)
    {
        $page->addMediaFromRequest('file')
             ->sanitizingFileName(function ($fileName) {
                 return md5($fileName).'.'.pathinfo($fileName, PATHINFO_EXTENSION);
             })
             ->toMediaCollection('default', config('cortex.pages.media.disk'));
    }

    /**
     * Delete the given resource from storage.
     *
     * @param \Rinvex\Pages\Contracts\PageContract $page
     * @param \Spatie\MediaLibrary\Models\Media    $media
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function delete(PageContract $page, Media $media)
    {
        $page->media()->where($media->getKeyName(), $media->getKey())->first()->delete();

        return intend([
            'url' => route('managerarea.pages.media.index', ['page' => $page]),
            'with' => ['warning' => trans('cortex/pages::messages.page.media_deleted')],
        ]);
    }
}
