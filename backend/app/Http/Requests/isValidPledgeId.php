<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Entities\Pledge;
use App\Entities\StudentsParent;
use Auth;

class IsValidPledgeId extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $userId   = Auth::id();
        $pledgeId = (int) $this->route('pledgeId');
        $pledge   = Pledge::find($pledgeId);

        if ($userId && $pledge) {
            return StudentsParent::where('parent_id', $userId)
                ->where('student_id', $pledge->participant_user_id)
                ->exists();
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
            //
        ];
    }
}
