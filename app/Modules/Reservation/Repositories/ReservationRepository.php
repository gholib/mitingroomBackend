<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 9/23/2020
 * Time: 4:50 PM
 */

namespace App\Modules\Reservation\Repositories;


use App\Modules\Reservation\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservationRepository
{
    private $sortKeys = [
        'myself' => 'getUserReservations',
        'today' => 'getTodayReservation',
    ];
    private $today;
    private $tomorrow;

    public function __construct()
    {
        $this->today = Carbon::today();
        $this->tomorrow = Carbon::tomorrow();
    }

    public function sortBy($sortKey)
    {
        $query = Reservation::active();

        $sortMethod = $this->sortKeys[$sortKey];
        $this->$sortMethod($query);

        $reservations = $query->orderBy('start_date')->get();

        return $reservations;
    }

    private function getUserReservations($query)
    {
        $user = Auth::user();
        $query->where('user_id', $user->id);
    }

    private function getTodayReservation($query)
    {
        $query->where([
            ['start_date', '>=', $this->today],
            ['start_date', '<=', $this->tomorrow]
        ]);
    }
}