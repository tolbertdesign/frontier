<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Rules\ValidParticipantForParent;

class UpdateParticipantRequest extends FormRequest
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
            'participant_id'          => ['required', 'integer', new ValidParticipantForParent],
            'classroom_id'            => 'required|integer',
            'first_name'              => 'required|string|max:255',
            'last_name'               => 'required|string|max:255',
            'pledge_goal'             => 'required|numeric',
            'pledge_page_text'        => 'sometimes',
            'family_pledging_enabled' => 'sometimes|integer',
            'photoFile'               => 'sometimes|image|max:20240',
            'deleteFile'              => 'sometimes|integer',
        ];
    }
}
