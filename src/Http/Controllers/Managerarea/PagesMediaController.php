<?php

declare(strict_types=1);

namespace Cortex\Pages\Http\Controllers\Managerarea;

use Cortex\Pages\Models\Page;
use Spatie\MediaLibrary\Models\Media;
use Cortex\Foundation\DataTables\MediaDataTable;
use Cortex\Foundation\Http\Requests\ImageFormRequest;
use Cortex\Foundation\Http\Controllers\AuthorizedController;

class PagesMediaController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = Page::class;

    /**
     * {@inheritdoc}
     */
    public function authorizeResource($model, $parameter = null, array $options = [], $request = null): void
    {
        $middleware = [];
        $parameter = $parameter ?: snake_case(class_basename($model));

        foreach ($this->mapResourceAbilities() as $method => $ability) {
            $modelName = in_array($method, $this->resourceMethodsWithoutModels()) ? $model : $parameter;

            $middleware["can:update,{$modelName}"][] = $method;
            $middleware["can:{$ability},media"][] = $method;
        }

        foreach ($middleware as $middlewareName => $methods) {
            $this->middleware($middlewareName, $options)->only($methods);
        }
    }

    /**
     * List all page media.
     *
     * @param \Cortex\Foundation\DataTables\MediaDataTable $mediaDataTable
     * @param \Cortex\Pages\Models\Page                    $page
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function index(Page $page, MediaDataTable $mediaDataTable)
    {
        return $mediaDataTable->with([
            'resource' => $page,
            'tabs' => 'managerarea.pages.tabs',
            'id' => "managerarea-pages-{$page->getRouteKey()}-media-table",
            'url' => route('managerarea.pages.media.store', ['page' => $page]),
        ])->render('cortex/foundation::managerarea.pages.datatable-dropzone');
    }

    /**
     * Store new page media.
     *
     * @param \Cortex\Foundation\Http\Requests\ImageFormRequest $request
     * @param \Cortex\Pages\Models\Page                         $page
     *
     * @return void
     */
    public function store(ImageFormRequest $request, Page $page): void
    {
        $page->addMediaFromRequest('file')
             ->sanitizingFileName(function ($fileName) {
                 return md5($fileName).'.'.pathinfo($fileName, PATHINFO_EXTENSION);
             })
             ->toMediaCollection('default', config('cortex.foundation.media.disk'));
    }

    /**
     * Destroy given page media.
     *
     * @param \Cortex\Pages\Models\Page         $page
     * @param \Spatie\MediaLibrary\Models\Media $media
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Page $page, Media $media)
    {
        $page->media()->where($media->getKeyName(), $media->getKey())->first()->delete();

        return intend([
            'url' => route('managerarea.pages.media.index', ['page' => $page]),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => trans('cortex/foundation::common.media'), 'identifier' => $media->getRouteKey()])],
        ]);
    }
}
