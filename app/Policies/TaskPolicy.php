<?php

namespace App\Policies;

use App\Board;
use App\User;
use App\Task;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */

    public function action(User $user, Task $task)
    {
       // return ;
        return $user->id === $task->user_id||$user->isModerator();
    }


    public function __construct()
    {
        //
    }
}
