<?php

namespace App\Modules\Reservation\Requests;

use App\Modules\Reservation\Validations\IsValidDate;
use Illuminate\Foundation\Http\FormRequest;

class ReservationUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'start_date' => 'required',
            'end_date' => 'required',
            'room_id' => ['required', new IsValidDate($this->start_date, $this->end_date, $this->reservation_id)],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Это поля даты начало и конец бронирования обязательны для заполнения',
        ];
    }
}
