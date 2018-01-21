<?php

declare(strict_types=1);

namespace Cortex\Pages\Http\Controllers\Adminarea;

use Rinvex\Pages\Models\Page;
use Spatie\MediaLibrary\Models\Media;
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
     * @param \Rinvex\Pages\Models\Page $page
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function index(Page $page)
    {
        return request()->ajax() && request()->wantsJson()
            ? app(MediaDataTable::class)->with(['resource' => $page])->ajax()
            : intend(['url' => route('adminarea.pages.edit', ['page' => $page]).'#media-tab']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Cortex\Foundation\Http\Requests\ImageFormRequest $request
     * @param \Rinvex\Pages\Models\Page                         $page
     *
     * @return void
     */
    public function store(ImageFormRequest $request, Page $page): void
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
     * @param \Rinvex\Pages\Models\Page         $page
     * @param \Spatie\MediaLibrary\Models\Media $media
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function delete(Page $page, Media $media)
    {
        $page->media()->where($media->getKeyName(), $media->getKey())->first()->delete();

        return intend([
            'url' => route('adminarea.pages.media.index', ['page' => $page]),
            'with' => ['warning' => trans('cortex/pages::messages.page.media_deleted')],
        ]);
    }
}
