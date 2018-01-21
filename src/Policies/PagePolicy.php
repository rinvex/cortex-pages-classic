<?php

declare(strict_types=1);

namespace Cortex\Pages\Policies;

use Rinvex\Fort\Models\User;
use Rinvex\Pages\Models\Page;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list pages.
     *
     * @param string                   $ability
     * @param \Rinvex\Fort\Models\User $user
     *
     * @return bool
     */
    public function list($ability, User $user): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can create pages.
     *
     * @param string                   $ability
     * @param \Rinvex\Fort\Models\User $user
     *
     * @return bool
     */
    public function create($ability, User $user): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can update the page.
     *
     * @param string                    $ability
     * @param \Rinvex\Fort\Models\User  $user
     * @param \Rinvex\Pages\Models\Page $resource
     *
     * @return bool
     */
    public function update($ability, User $user, Page $resource): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can update pages
    }

    /**
     * Determine whether the user can delete the page.
     *
     * @param string                    $ability
     * @param \Rinvex\Fort\Models\User  $user
     * @param \Rinvex\Pages\Models\Page $resource
     *
     * @return bool
     */
    public function delete($ability, User $user, Page $resource): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can delete pages
    }
}
