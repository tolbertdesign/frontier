<?php

namespace App\Http\Requests;

use App\Rules\MeetsMinimumAge;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateParentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|'
                . 'not_regex:/(.+)@boosterthon\.com$/i',
            'phone'      => 'required|regex:/^[\d]{10}$/',
            'dob'        => [
                'required',
                'regex:/^[\d]{4}-[\d]{2}-[\d]{2}$/',
                new MeetsMinimumAge
            ]
        ];
    }
}
