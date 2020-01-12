<?php

namespace App\Policies;

use App\Models\Dialog;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    public function view(User $user, Dialog $dialog)
    {
        $users = $dialog->users()->get();

        foreach ($users as $v)
        {
            if($v->id === $user->id) return true;
        }
    }
}
