<?php

namespace App\Policies;

use App\Models\Blog\BlogComment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogCommentPolicy
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
        return $user->isCommentator();
    }

    /**
     * Determine whether the user can update the blog post.
     *
     * @param User $user
     * @param BlogComment $comment
     * @return boolean
     */
    public function update(User $user, BlogComment $comment)
    {
        return $user->isEditor() or $user->id === $comment->user_id;
    }

    /**
     * Determine whether the user can delete the blog post.
     *
     * @param User $user
     * @param BlogComment $comment
     * @return boolean
     */
    public function delete(User $user, BlogComment $comment)
    {
        return $user->isEditor() or $user->id === $comment->user_id;
    }
}
