<?php

namespace App\Policies;

use App\Models\Forum\ForumReply;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumReplyPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can create forum replies.
     *
     * @param User $user
     * @return mixed
     */
    public function store(User $user)
    {
        return $user->isCommentator();
    }

    /**
     * Determine whether the user can update the forum reply.
     *
     * @param User $user
     * @param ForumReply $forumReply
     * @return mixed
     */
    public function update(User $user, ForumReply $forumReply)
    {
        return $user->isEditor() or $user->id === $forumReply->used_id;
    }

    /**
     * Determine whether the user can delete the forum reply.
     *
     * @param User $user
     * @param ForumReply $forumReply
     * @return mixed
     */
    public function delete(User $user, ForumReply $forumReply)
    {
        return $user->isEditor() or $user->id === $forumReply->used_id;
    }

}
