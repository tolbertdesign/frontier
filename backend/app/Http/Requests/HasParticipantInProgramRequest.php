<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use DB;

class HasParticipantInProgramRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!Auth::check() || !is_numeric($this->route('programId'))) {
            return false;
        }

        $programId = (int) $this->route('programId');
        $parentId  = Auth::id();

        return DB::table('groups')
            ->join('classrooms', 'classrooms.group_id', '=', 'groups.id')
            ->join('participants', 'participants.classroom_id', '=', 'classrooms.id')
            ->join('students_parents', 'students_parents.student_id', '=', 'participants.user_id')
            ->where('students_parents.parent_id', '=', $parentId)
            ->where('groups.program_id', '=', $programId)
            ->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

        ];
    }
}
