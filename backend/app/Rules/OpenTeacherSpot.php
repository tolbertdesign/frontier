<?php

namespace App\Rules;

use App\Source;
use Illuminate\Contracts\Validation\Rule;
use App\Entities\Classroom;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class OpenTeacherSpot implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $classroom = Classroom::where('team_leader_code', $value)->firstOrFail();
        if (empty($classroom->teacher_id) || empty($classroom->teacher_2_id) || empty($classroom->teacher_3_id)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return Lang::get('register.max_teachers_reached');
    }
}
