<?php

declare(strict_types=1);

namespace Cortex\Pages\Policies;

use Rinvex\Fort\Contracts\UserContract;
use Rinvex\Pages\Contracts\PageContract;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list pages.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Contracts\UserContract $user
     *
     * @return bool
     */
    public function list($ability, UserContract $user)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can create pages.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Contracts\UserContract $user
     *
     * @return bool
     */
    public function create($ability, UserContract $user)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can update the page.
     *
     * @param string                               $ability
     * @param \Rinvex\Fort\Contracts\UserContract  $user
     * @param \Rinvex\Pages\Contracts\PageContract $resource
     *
     * @return bool
     */
    public function update($ability, UserContract $user, PageContract $resource)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can update pages
    }

    /**
     * Determine whether the user can delete the page.
     *
     * @param string                               $ability
     * @param \Rinvex\Fort\Contracts\UserContract  $user
     * @param \Rinvex\Pages\Contracts\PageContract $resource
     *
     * @return bool
     */
    public function delete($ability, UserContract $user, PageContract $resource)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can delete pages
    }
}
