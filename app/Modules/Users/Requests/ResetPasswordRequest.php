<?php


namespace App\Modules\Users\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() :bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() :array
    {
        return [
            'email' => 'required|exists:users',
            'password' => [
                'required',
                'min:6'
            ],
            'reset_password_token' => [
                'required',
                Rule::exists('users')->where(function ($query) {
                    $query->where('email', $this->email)->where('reset_password_token', $this->reset_password_token);
                }),
            ],
        ];
    }

    public function messages() :array
    {
        return [
            'required' => 'Поля :attribute обязательно для заполнения.',
            'token.exists' => 'Токен недействителен',
        ];
    }

}
