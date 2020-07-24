<?php

namespace App\Policies;

use App\User;
use App\Board;
use Illuminate\Auth\Access\HandlesAuthorization;

class BoardPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */

    public function action(User $user, Board $board)
    {
        return $user->id === $board->user_id||$user->isModerator();
    }
    public function __construct()
    {
        //
    }
}
