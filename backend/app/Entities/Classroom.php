<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\PledgeType;
use App\Entities\Pledge;
use DB;

class Classroom extends Model
{
    protected $appends =[
        'pledgedPlaces'
    ];

    public $timestamps = false;

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function program()
    {
        return $this->hasOneThrough(Program::class, Group::class);
    }

    public function manualPayments()
    {
        return $this->hasMany(ManualPayment::class);
    }

    public function classroomShirt()
    {
        return $this->hasOne(ClassroomShirt::class);
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function participantUsers()
    {
        return $this->belongsToMany(User::class, 'participants');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function getPledgedPlacesAttribute()
    {
        $states = DB::table('pledges')
                ->join('pledge_sponsors', 'pledge_sponsors.id', '=', 'pledges.pledge_sponsor_id')
                ->join('users', 'users.id', '=', 'pledges.participant_user_id')
                ->join('participants', 'participants.user_id', '=', 'pledges.participant_user_id')
                ->join('classrooms', 'classrooms.id', '=', 'participants.classroom_id')
                ->join('groups', 'groups.id', '=', 'classrooms.group_id')
                ->join('programs', 'programs.id', '=', 'groups.program_id')
                ->join('pledge_statuses', 'pledge_statuses.id', '=', 'pledges.pledge_status_id')
                ->where('participants.classroom_id', '=', $this->id)
                ->whereIn('pledges.pledge_status_id', Pledge::STATE_MAP_STATUSES)
                ->where('pledges.deleted', '=', 0)
                ->where('users.deleted', '=', 0)
                ->whereNotNull('pledge_sponsors.state')
                ->where('pledge_sponsors.state', '!=', '')
                ->groupBy('pledge_sponsors.state')
                ->select('pledge_sponsors.state')
                ->get()
                ->pluck('state')
                ->toArray();

        $countries = DB::table('pledges')
                ->join('pledge_sponsors', 'pledge_sponsors.id', '=', 'pledges.pledge_sponsor_id')
                ->join('users', 'users.id', '=', 'pledges.participant_user_id')
                ->join('participants', 'participants.user_id', '=', 'pledges.participant_user_id')
                ->join('classrooms', 'classrooms.id', '=', 'participants.classroom_id')
                ->join('groups', 'groups.id', '=', 'classrooms.group_id')
                ->join('programs', 'programs.id', '=', 'groups.program_id')
                ->join('pledge_statuses', 'pledge_statuses.id', '=', 'pledges.pledge_status_id')
                ->join('countries', 'pledge_sponsors.country', '=', 'countries.iso')
                ->where('participants.classroom_id', '=', $this->id)
                ->whereIn('pledges.pledge_status_id', Pledge::STATE_MAP_STATUSES)
                ->where('pledges.deleted', '=', 0)
                ->where('users.deleted', '=', 0)
                ->groupBy('countries.id')
                ->select('countries.name as country')
                ->get()
                ->pluck('country')
                ->toArray();

        return [
            'states'    => $states,
            'countries' => $countries,
        ];
    }

    public function pledges()
    {
        return $this->belongsToMany(Pledge::class, 'participant');
    }

    public function scopeWithPledgeTotals($query, int $programId)
    {
        $programPledgeSetting = ProgramPledgeSetting::where('program_id', $programId)->first();

        $isFlatDonateOnly = ($programPledgeSetting && $programPledgeSetting->flat_donate_only === 1 ? '!= ' : '= ');
        $multiplyOrDivide = ($programPledgeSetting && $programPledgeSetting->flat_donate_only === 1 ? '*' : '/');

        return $query->select('classrooms.id', 'classrooms.name', 'grades.display_name as gradeText', DB::raw(
            'SUM(
                IF(pledges.pledge_type_id ' . $isFlatDonateOnly . PledgeType::FLAT . ',
                    (pledges.amount' . $multiplyOrDivide . 'programs.unit_flat_conversion)
                , amount)
            ) AS pledgeTotal'
        ))
            ->join('grades', 'grades.id', '=', 'classrooms.grade_id')
            ->join('groups', 'groups.id', '=', 'classrooms.group_id')
            ->join('programs', 'programs.id', '=', 'groups.program_id')
            ->leftJoin('participants', 'classrooms.id', '=', 'participants.classroom_id')
            ->leftJoin('pledges', function ($join) {
                $join->on('pledges.program_id', '=', 'programs.id');
                $join->on('participants.user_id', '=', 'pledges.participant_user_id');
                $join->where('pledges.deleted', 0);
                $join->whereIn('pledges.pledge_status_id', Pledge::$paymentPledgedStatusIds);
            })
            ->where('programs.id', $programId)
            ->where('classrooms.deleted', 0)
            ->groupBy('classrooms.id')
            ->orderBy('pledgeTotal', 'DESC');
    }

    public function getPledgeTotal()
    {
        $group = Group::where('id', $this->group_id)->first()->load('program', 'program.programPledgeSetting');
        if (!$group || !$group->program) {
            return 0;
        }

        $programPledgeSetting = $group->program->programPledgeSetting;

        $isFlatDonateOnly = ($programPledgeSetting && $programPledgeSetting->flat_donate_only === 1 ? '!= ' : '= ');
        $multiplyOrDivide = ($programPledgeSetting && $programPledgeSetting->flat_donate_only === 1 ? '*' : '/');

        $record = Classroom::select(DB::raw(
            'SUM(
                IF(pledges.pledge_type_id ' . $isFlatDonateOnly . PledgeType::FLAT . ',
                    (pledges.amount' . $multiplyOrDivide . 'programs.unit_flat_conversion)
                , amount)
            ) AS pledgeTotal'
        ))
            ->join('grades', 'grades.id', '=', 'classrooms.grade_id')
            ->join('groups', 'groups.id', '=', 'classrooms.group_id')
            ->join('programs', 'programs.id', '=', 'groups.program_id')
            ->leftJoin('participants', 'classrooms.id', '=', 'participants.classroom_id')
            ->leftJoin('pledges', function ($join) {
                $join->on('participants.user_id', '=', 'pledges.participant_user_id');
                $join->where('pledges.deleted', 0);
                $join->whereIn('pledges.pledge_status_id', Pledge::$paymentPledgedStatusIds);
            })
            ->where('classrooms.id', $this->id)
            ->groupBy('classrooms.id')
            ->get();

        return (float)$record[0]->pledgeTotal;
    }

    /**
     * Returns an array of teacher ids for the classroom
     *
     * @return Array teacher user ids
     */
    public function getTeachersUserIds()
    {
        return [
            $this->teacher_id,
            $this->teacher_2_id,
            $this->teacher_3_id
        ];
    }

    public function getTeacherLastName()
    {
        $lastName = null;

        foreach ($this->getTeachersUserIds() as $teacherId) {
            $teacher = User::find($teacherId);

            if ($teacher !== null) {
                $lastName = $teacher->last_name;
                break;
            }
        }

        return $lastName;
    }
}
