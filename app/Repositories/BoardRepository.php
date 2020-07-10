<?php


namespace App\Repositories;

use App\Board;
use App\User;

class BoardRepository
{
    public function forUser(User $user)
    {
        return $user->boards()
            ->orderBy('created_at', 'asc')
            ->get();
    }

}
