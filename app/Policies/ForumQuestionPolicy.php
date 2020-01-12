<?php

namespace App\Policies;

use App\Models\Forum\ForumQuestion;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumQuestionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create blog posts.
     *
     * @param User $user
     * @return boolean
     */

    public function view(User $user)
    {
        return $user->isCommentator();
    }

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
     * @param ForumQuestion $forumQuestion
     * @return boolean
     */
    public function update(User $user, ForumQuestion $forumQuestion)
    {
        return $user->isEditor() or $user->id === $forumQuestion->user_id;
    }

    /**
     * Determine whether the user can delete the blog post.
     *
     * @param User $user
     * @param ForumQuestion $forumQuestion
     * @return boolean
     */
    public function delete(User $user, ForumQuestion $forumQuestion)
    {
        return $user->isEditor() or $user->id === $forumQuestion->user_id;
    }
}
