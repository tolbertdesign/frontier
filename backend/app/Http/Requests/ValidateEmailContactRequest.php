<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use Illuminate\Validation\Rule;

class ValidateEmailContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->participants()->where('student_id', $this->participantUserId)->exists()) {
            return true;
        }

        return abort(403, 'There was an error. Please try again.');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'contacts.*.firstName'    => 'required|string|max:255',
            'contacts.*.lastName'     => 'nullable|string|max:255',
            'contacts.*.emailAddress' => [
                'required',
                'string',
                'email',
                Rule::unique('potential_sponsors', 'email')->where(function ($query) {
                    return $query->where(['participant_user_id' => $this->participantUserId, 'deleted' => 0]);
                }),
                'max:255',
            ],
            'participantUserId' => 'required|integer'
        ];
    }
}
