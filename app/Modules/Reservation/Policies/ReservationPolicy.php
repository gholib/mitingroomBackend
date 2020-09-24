<?php

namespace App\Modules\Reservation\Policies;

use App\Modules\Auth\Models\User;
use App\Modules\Reservation\Models\Reservation;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReservationPolicy
{
    public function update(User $user, Reservation $reservation)
    {
        return $user->id === $reservation->user_id;
    }

    public function delete(User $user, Reservation $reservation)
    {
        return $user->id === $reservation->user_id;
    }
}
