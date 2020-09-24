<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 9/23/2020
 * Time: 12:41 PM
 */

namespace App\Modules\Reservation\Services;


use App\Modules\Reservation\Models\Reservation;
use App\Modules\Room\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReservationService
{
    /**
     * @param $roomId
     * @param $startDate
     * @param $endDate
     * @return bool
     */
    public static function canBooking($roomId, $reservationId, $startDate, $endDate)
    {
        $reservations = Reservation::where('room_id',$roomId)
                ->where('id', '!=', $reservationId)
                ->active()
                ->where(function ($query) use($startDate, $endDate) {
                    $query->whereBetween('start_date',[$startDate, $endDate])
                        ->orWhereBetween('end_date',[$startDate, $endDate])
                        ->orWhere([
                            ['start_date', '<=', $startDate],
                            ['end_date', '>=', $endDate]
                        ]);
                })
                ->get();

        return count($reservations) === 0;
    }

    public static function checkReservation()
    {
        $inactiveReservations = Reservation::allInactive()->get();
        $reservationIds = [];
        foreach ($inactiveReservations as $reservation) {
            $reservationIds[] = $reservation->id;
        }

        DB::table('reservations')->whereIn('id', $reservationIds)
            ->update([
                'status' => 'inactive'
            ]);
    }
}