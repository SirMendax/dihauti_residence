<?php

namespace App\Policies;

use App\Models\Blog\BlogCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogCategoryPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can create blog posts.
     *
     * @param User $user
     * @return boolean
     */
    public function store(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the blog post.
     *
     * @param User $user
     * @return boolean
     */
    public function update(User $user)
    {
        return $user->isEditor();
    }

    /**
     * Determine whether the user can delete the blog post.
     *
     * @param User $user
     * @return boolean
     */
    public function delete(User $user)
    {
        return $user->isAdmin();
    }

}
