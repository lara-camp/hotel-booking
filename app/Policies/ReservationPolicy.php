<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReservationPolicy
{
    /**
     * Determine whether a person can make reservation.
     */
    public function create(User $user): bool
    {
        return $user->role_id === 2;
    }

    /**
     * Determine whether a person can update reservation.
     */
    public function update(User $user,Reservation $reservation): bool
    {
        return $user->role_id === 1 || Auth::user()->id === $reservation->user_id;
    }

    /**
     * Determine whether the a person can cancel reservation.
     */
    public function delete(User $user,Reservation $reservation): bool
    {
        return $user->role_id === 1 || Auth::user()->id === $reservation->user_id;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Reservation $reservation): bool
    {
        return $user->role_id === 1 || $user->role_id === 2;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role_id === 2;
    }

}
