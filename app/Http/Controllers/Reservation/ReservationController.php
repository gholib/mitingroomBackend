<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Modules\Reservation\Models\Reservation;
use App\Modules\Reservation\Repositories\ReservationRepository;
use App\Modules\Reservation\Requests\ReservationStoreRequest;
use App\Modules\Reservation\Requests\ReservationUpdateRequest;
use App\Modules\Reservation\Services\ReservationService;
use App\Modules\Reservation\UseCases\ReservationStore;
use App\Modules\Reservation\UseCases\ReservationUpdate;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * @var ReservationStore $reservationStore
     */
    private $reservationStore;
    /**
     * @var ReservationUpdate $reservationUpdate
     */
    private $reservationUpdate;

    /**
     * ReservationController constructor.
     * @param ReservationStore $reservationStore
     * @param ReservationUpdate $reservationUpdate
     */
    public function __construct(ReservationStore $reservationStore, ReservationUpdate $reservationUpdate)
    {
        $this->reservationStore = $reservationStore;
        $this->reservationUpdate = $reservationUpdate;
        ReservationService::checkReservation();
    }

    /**
     * @return array
     */
    public function getAll($roomId)
    {
        $reservations = Reservation::where('room_id', $roomId)->with('partners')->active()->orderBy('start_date')->get();

        return compact('reservations');
    }

    /**
     * @param ReservationStoreRequest $request
     * @return array
     */
    public function store(ReservationStoreRequest $request)
    {
        $reservation = $this->reservationStore->perform($request->all());

        return compact('reservation');
    }

    /**
     * @param ReservationUpdateRequest $request
     * @param $reservationId
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(ReservationUpdateRequest $request, $reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);

        $this->authorize('update', $reservation);
        $reservation = $this->reservationUpdate->perform($request->all(), $reservation);

        return compact('reservation');
    }

    /**
     * @param $reservationId
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);

        $this->authorize('delete', $reservation);
        $reservation->status = 'inactive';
        $reservation->update();
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function sortBy(Request $request)
    {
        $this->validate($request, [
            'sortKey' => 'required'
        ]);

        $reservations = (new ReservationRepository)->sortBy($request->sortKey);

        return compact('reservations');
    }
}
