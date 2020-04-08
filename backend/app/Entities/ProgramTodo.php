<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ProgramTodo extends Model
{
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public static function getLabelList()
    {
        return [
            'TODO_TOTAL_RAISED_GOAL'                => 'total_raised_goal',
            'TODO_MISSING_VIDEO'                    => 'missing_video',
            'TODO_FUNDS_RAISED_FOR_PICTURE'         => 'funds_raised_for_picture',
            'TODO_FUNDS_RAISED_FOR_DESCRIPTION'     => 'funds_raised_for_desc',
            'TODO_REMINDER_FOLLOWUP_DAY'            => 'reminder_followup_day',
            'TODO_REMINDER_AFTER_FIRST'             => 'reminder_after_first',
            'TODO_SPONSOR_FOLLOWUP'                 => 'sponsor_followup',
            'TODO_MISSING_PAYEE'                    => 'missing_payee',
            'TODO_MISSING_LAPS'                     => 'missing_laps',
            'TODO_TOP_PRIZE_DELIVERY'               => 'top_prize_delivery',
            'TODO_TEACHER_PRIZE_DELIVERY'           => 'teacher_prize_delivery',
            'TODO_UNPAID_SPONSOR_FOLLOW_UP_EMAIL_1' => 'unpaid_sponsor_follow_up_email_1',
            'TODO_UNPAID_SPONSOR_FOLLOW_UP_EMAIL_2' => 'unpaid_sponsor_follow_up_email_2',
            'TODO_PARENT_COLLECTION_LETTER'         => 'parent_collection_letter'
        ];
    }
}
