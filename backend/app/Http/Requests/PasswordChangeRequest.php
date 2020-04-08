<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Rules\ValidPassword;

class PasswordChangeRequest extends FormRequest
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
        $validator = new ValidPassword;
        $validator->useShortPasswordMessages(true);

        $passwordRules = ['bail', 'required', 'string', $validator];

        return [
            'current' => ['bail', 'required']
            ,'password' => $passwordRules + ['confirmed']
            ,'password_confirmation' => $passwordRules
        ];
    }
}
