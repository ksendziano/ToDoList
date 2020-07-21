<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function action(User $user)
    {
        return $user->moderator==1;
    }
    public function __construct()
    {
        //
    }
}
