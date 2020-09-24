<?php

namespace App\Modules\Reservation\Validations;

use App\Modules\Reservation\Services\ReservationService;
use App\Modules\Room\Models\Room;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class IsValidDate implements Rule
{
    private $startDate;
    private $endDate;
    private $message;
    private $today;
    private $reservationId;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($startDate, $endDate, $reservationId = null)
    {
        $this->startDate = Carbon::parse($startDate);
        $this->endDate = Carbon::parse($endDate);
        $this->reservationId = $reservationId;
        $this->today = Carbon::today();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $roomId)
    {
        if ($this->startDate < $this->today || $this->endDate < $this->today){
            $this->message = "Не правильный формат даты, прошедщее время не может быть зарегистрировано!";
            return false;
        }

        if ($this->startDate >= $this->endDate) {
            $this->message = "Не правильный формат даты, дата окончания не может быть раньше чем даты начало!";
            return false;
        }

        if (!ReservationService::canBooking($roomId, $this->reservationId, $this->startDate, $this->endDate)) {
            $this->message = "В это время комната уже занято!";
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
