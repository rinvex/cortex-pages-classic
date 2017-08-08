<?php

declare(strict_types=1);

namespace Cortex\Pages\Models;

use Illuminate\Support\Facades\Artisan;
use Rinvex\Pages\Models\Page as BasePage;
use Spatie\Activitylog\Traits\LogsActivity;

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
