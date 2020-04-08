<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lang;

class UserRegistrationRequest extends FormRequest
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
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required_unless:is_social_registration,true|string|email|max:255|unique:users|confirmed',
            'password'   => 'required_unless:is_social_registration,true|string|min:6',
            'phone'      => 'required|digits:10',
            'year'       => 'required|integer',
            'day'        => 'required|integer',
            'month'      => 'required|integer',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'digits' => Lang::get('validation.phone'),
        ];
    }
}
