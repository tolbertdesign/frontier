<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Entities\StudentsParent;

class IsParentOfParticipant implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $participantUserId
     * @return bool
     */
    public function passes($attribute, $participantUserId)
    {
        return StudentsParent::where(['parent_id' => Auth::id(), 'student_id' => $participantUserId])->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Cannot access this participant.';
    }
}
