<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Rules\IsParentOfParticipant;

class IsParentOfParticipantRequest extends FormRequest
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
        $participantUserIdRules = ['required', 'integer', new IsParentOfParticipant];
        return [
            'participantUserId' => $participantUserIdRules
        ];
    }
}
