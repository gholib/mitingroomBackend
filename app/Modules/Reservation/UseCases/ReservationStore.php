<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 9/23/2020
 * Time: 10:28 AM
 */

namespace App\Modules\Reservation\UseCases;


use App\Modules\Reservation\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationStore
{
    public function perform(array  $attributes)
    {
        $user = Auth::user();
        $reservation = new Reservation();

        $reservation->room_id = $attributes['room_id'];
        $reservation->user_id = $user->id;
        $reservation->start_date = $attributes['start_date'];
        $reservation->end_date = $attributes['end_date'];
        $reservation->description = $attributes['description'] ?? "";
        $reservation->save();

        if (isset($attributes['partners']) && count($attributes['partners']) > 0) {
            $partners = [];
            foreach ($attributes['partners'] as $partner) {
                $partners[] = [
                    'reservation_id' => $reservation->id,
                    'name' => $partner
                ];
            }

            DB::table('partners')->insert($partners);
        }

        $reservation->load('partners');

        return $reservation;
    }
}