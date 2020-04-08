<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Lang;
use DB;

class UniqueParticipant implements Rule
{
    public $firstName;
    public $lastName;
    public $classroomId;
    public $participantCount;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($firstName, $lastName, $classroomId)
    {
        $this->firstName   = $firstName;
        $this->lastName    = $lastName;
        $this->classroomId = $classroomId;
    }

    /**
     * Determine if a participant exists with same first name, last name, and classroom ID
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (is_numeric($this->classroomId)) {
            $this->participantCount = DB::table('participants')
                    ->join('users', 'participants.user_id', '=', 'users.id')
                    ->where('users.first_name', '=', $this->firstName)
                    ->where('users.last_name', '=', $this->lastName)
                    ->where('participants.classroom_id', '=', $this->classroomId)
                    ->where('users.deleted', '!=', 1)
                    ->count();
        }
        return $this->participantCount === 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return Lang::get('validation.new_student');
    }
}
