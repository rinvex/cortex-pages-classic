<?php

declare(strict_types=1);

namespace Cortex\Pages\Models;

use Illuminate\Support\Facades\Artisan;
use Rinvex\Pages\Models\Page as BasePage;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Cortex\Pages\Models\Page.
 *
 * @property int                                                                           $id
 * @property string                                                                        $uri
 * @property string                                                                        $slug
 * @property string                                                                        $domain
 * @property string                                                                        $middleware
 * @property array                                                                         $title
 * @property array                                                                         $subtitle
 * @property array                                                                         $excerpt
 * @property array                                                                         $content
 * @property string                                                                        $view
 * @property bool                                                                          $is_active
 * @property int                                                                           $sort_order
 * @property \Carbon\Carbon                                                                $created_at
 * @property \Carbon\Carbon                                                                $updated_at
 * @property \Carbon\Carbon                                                                $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cortex\Foundation\Models\Log[] $activity
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page active()
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page inactive()
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Pages\Models\Page ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereMiddleware($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereUri($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereView($value)
 * @mixin \Eloquent
 */
class Page extends BasePage
{
    use LogsActivity;

    /**
     * Indicates whether to log only dirty attributes or all.
     *
     * @var bool
     */
    protected static $logOnlyDirty = true;

    /**
     * The attributes that are logged on change.
     *
     * @var array
     */
    protected static $logAttributes = [
        'slug',
        'name',
        'description',
        'sort_order',
        'group',
    ];

    /**
     * The attributes that are ignored on change.
     *
     * @var array
     */
    protected static $ignoreChangedAttributes = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * {@inheritdoc}
     */
    protected static function boot()
    {
        parent::boot();

        // Update routes
        static::saved(function () {
            Artisan::call('route:cache');
            Artisan::call('laroute:generate');
        });
    }
}
