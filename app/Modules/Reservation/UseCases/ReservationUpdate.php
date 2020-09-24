<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 9/23/2020
 * Time: 3:24 PM
 */

namespace App\Modules\Reservation\UseCases;


use App\Modules\Partners\Models\Partner;
use App\Modules\Reservation\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationUpdate
{
    public function perform(array  $attributes,Reservation $reservation)
    {
        $reservation->room_id = $attributes['room_id'];
        $reservation->start_date = $attributes['start_date'];
        $reservation->end_date = $attributes['end_date'];
        $reservation->description = $attributes['description'] ?? "";
        $reservation->update();

        Partner::where('reservation_id', $reservation->id)->delete();

        if (isset($attributes['partners']) && count($attributes['partners']) > 0) {
            $partners = [];
            foreach ($attributes['partners'] as $partner) {
                $partners[] = [
                    'reservation_id' => $reservation->id,
                    'name' => $partner['name'] ?? $partner
                ];
            }

            DB::table('partners')->insert($partners);
        }

        $reservation->load('partners');

        return $reservation;
    }
}