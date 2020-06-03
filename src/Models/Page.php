<?php

declare(strict_types=1);

namespace Cortex\Pages\Models;

use Rinvex\Tags\Traits\Taggable;
use Spatie\MediaLibrary\HasMedia;
use Rinvex\Tenants\Traits\Tenantable;
use Cortex\Foundation\Traits\Auditable;
use Rinvex\Support\Traits\HashidsTrait;
use Rinvex\Pages\Models\Page as BasePage;
use Cortex\Foundation\Events\ModelCreated;
use Cortex\Foundation\Events\ModelDeleted;
use Cortex\Foundation\Events\ModelUpdated;
use Cortex\Foundation\Events\ModelRestored;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Cortex\Foundation\Traits\FiresCustomModelEvent;

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
    use Tenantable;
    use HashidsTrait;
    use LogsActivity;
    use InteractsWithMedia;
    use FiresCustomModelEvent;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ModelCreated::class,
        'deleted' => ModelDeleted::class,
        'restored' => ModelRestored::class,
        'updated' => ModelUpdated::class,
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
     * {@inheritdoc}
     */
    protected $fillable = [
        'uri',
        'slug',
        'title',
        'route',
        'subtitle',
        'domain',
        'middleware',
        'excerpt',
        'content',
        'view',
        'is_active',
        'sort_order',
        'tags',
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
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('rinvex.pages.tables.pages'));
        $this->setRules([
            'uri' => 'required|regex:/^([0-9a-z\/_-]+)$/|max:150|unique:'.config('rinvex.pages.tables.pages').',uri,NULL,id,domain,'.($this->domain ?? 'null'),
            'slug' => 'required|alpha_dash|max:150|unique:'.config('rinvex.pages.tables.pages').',slug,NULL,id,domain,'.($this->domain ?? 'null'),
            'route' => 'required|regex:/^([0-9a-z\._-]+)$/|max:150|unique:'.config('rinvex.pages.tables.pages').',route,NULL,id,domain,'.($this->domain ?? 'null'),
            'domain' => 'nullable|string|strip_tags|max:150',
            'middleware' => 'nullable|string|strip_tags|max:150',
            'title' => 'required|string|strip_tags|max:150',
            'subtitle' => 'nullable|string|strip_tags|max:150',
            'excerpt' => 'nullable|string|max:10000',
            'content' => 'nullable|string|max:100000',
            'view' => 'required|string|strip_tags|max:150',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer|max:10000',
            'tags' => 'nullable|array',
        ]);
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
