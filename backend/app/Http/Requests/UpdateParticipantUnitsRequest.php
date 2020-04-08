<?php

namespace App\Http\Requests;

use App\Entities\StudentsParent;
use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UpdateParticipantUnitsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check()) {
            $participantUserId = (int)$this->route('id');
            if ($this->isParent($participantUserId)) {
                return true;
            }
        }

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
            'units' => 'required|integer|min:10'
        ];
    }

    /**
     * Determine if user is the parent of the participant.
     *
     * @return bool
     */
    private function isParent($participantUserId)
    {
        return StudentsParent::where('student_id', $participantUserId)
            ->where('parent_id', Auth::id())
            ->exists();
    }
}
