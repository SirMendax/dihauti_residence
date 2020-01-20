<?php


namespace App\Services\AuthSystem;


use App\Models\User;

class RoleDistributor
{
    /**
     * @param User $user
     * @return User
     */
    public static function setRole(User $user)
    {
        $user->roles()->detach(2);
        $user->roles()->attach(3);
        return $user;
    }
}
