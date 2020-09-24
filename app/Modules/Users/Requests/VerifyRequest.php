<?php

namespace App\Modules\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VerifyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|exists:users',
            'verify_token' => [
                'required',
                Rule::exists('users')->where(function ($query) {
                    $query->where('email', $this->email)->where('verify_token', $this->verify_token);
                }),
            ],
        ];
    }

    public function messages() :array
    {
        return [
            'required' => 'Нехватает данных.',
            'token.exists' => 'Токен недействителен',
        ];
    }
}
