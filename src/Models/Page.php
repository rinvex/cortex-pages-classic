<?php

declare(strict_types=1);

namespace Cortex\Pages\Models;

use Rinvex\Tags\Traits\Taggable;
use Spatie\MediaLibrary\HasMedia;
use Cortex\Pages\Events\PageCreated;
use Cortex\Pages\Events\PageDeleted;
use Cortex\Pages\Events\PageUpdated;
use Rinvex\Support\Traits\Macroable;
use Cortex\Pages\Events\PageRestored;
use Rinvex\Tenants\Traits\Tenantable;
use Cortex\Foundation\Traits\Auditable;
use Rinvex\Support\Traits\HashidsTrait;
use Rinvex\Support\Traits\HasTimezones;
use Rinvex\Pages\Models\Page as BasePage;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Cortex\Pages\Models\Page.
 *
 * @property int                                                                           $id
 * @property string                                                                        $uri
 * @property string                                                                        $slug
 * @property string                                                                        $route
 * @property string                                                                        $domain
 * @property string                                                                        $middleware
 * @property array                                                                         $title
 * @property array                                                                         $subtitle
 * @property array                                                                         $excerpt
 * @property array                                                                         $content
 * @property string                                                                        $view
 * @property bool                                                                          $is_active
 * @property int                                                                           $sort_order
 * @property \Carbon\Carbon|null                                                           $created_at
 * @property \Carbon\Carbon|null                                                           $updated_at
 * @property \Carbon\Carbon|null                                                           $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cortex\Foundation\Models\Log[] $activity
 * @property \Illuminate\Database\Eloquent\Collection|\Cortex\Tenants\Models\Tenant[]      $tenants
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereMiddleware($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereUri($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page whereView($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page withAllTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page withAnyTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page withTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page withoutAnyTenants()
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Pages\Models\Page withoutTenants($tenants, $group = null)
 * @mixin \Eloquent
 */
class Page extends BasePage implements HasMedia
{
    use Taggable;
    use Auditable;
    use Macroable;
    use Tenantable;
    use HashidsTrait;
    use HasTimezones;
    use LogsActivity;
    use InteractsWithMedia;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => PageCreated::class,
        'updated' => PageUpdated::class,
        'deleted' => PageDeleted::class,
        'restored' => PageRestored::class,
    ];

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
    protected static $logFillable = true;

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
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->mergeFillable(['tags']);

        $this->mergeRules(['tags' => 'nullable|array']);

        $this->setTable(config('rinvex.pages.tables.pages'));
    }

    /**
     * Register media collections.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_picture')->singleFile();
        $this->addMediaCollection('cover_photo')->singleFile();
    }
}
