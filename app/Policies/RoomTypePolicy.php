<?php

namespace App\Policies;

use App\Models\User;

class RoomTypePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function store(User $user) : bool {
        return $user->role_id === 1;
    }

    public function update(User $user) : bool {
        return $user->role_id === 1;
    }
}
