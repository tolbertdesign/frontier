<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateUserTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!Auth::check()) {
            return false;
        }

        $userTask = $this->route('user_task');
        $teacherParticipant = Auth::user()->teacherParticipant();

        if (!$teacherParticipant || !$userTask) {
            return false;
        }
        return $userTask->exists() && $userTask->assigned_to_user_id === $teacherParticipant->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'completed_on_date' => 'nullable|date'
        ];
    }
}
