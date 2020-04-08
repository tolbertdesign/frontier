<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class School extends Model
{
    public $timestamps = false;

    public function schoolEscrowTransactions()
    {
        return $this->hasMany(SchoolEscrowTransaction::class);
    }

    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    /**
     * the organization administrators for this school
     *
     * @return void
     */
    public function orgAdmins()
    {
        return $this->belongsToMany(
            OrganizationAdministrator::class,
            'organization_administrators',
            'school_id',
            'user_id'
        );
    }

    public function braintreeMerchant()
    {
        return $this->hasOne(BraintreeMerchant::class);
    }

    public function activePrograms()
    {
        return $this->programs()->where('pledging_start', '<', Carbon::now())
            ->where('pledging_end', '<', Carbon::now())
            ->get();
    }

    /**
     * Search for a school by name
     *
     * @param String Registration code
     * @param Bool $isGivingMarketProgram
     * @return App\Entities\School Collection of schools with school name, city state and program registration code.
     */
    public static function searchSchoolByName(String $search, Bool $isGivingMarketProgram = true)
    {
        //lets clean and prep the search string
        $search       = '%' . filter_var(str_replace('.', '', trim($search)), FILTER_SANITIZE_STRING) . '%';
        $program_type = DB::table('program_types')
            ->where('namespace', '=', 'giving_market')
            ->first();

        return DB::table('schools')
            ->select(
                [
                    'schools.name',
                    'schools.city',
                    'schools.state',
                    'schools.id as school_id',
                    'programs.event_name',
                    'programs.registration_code',
                    'programs.id',
                ]
            )
            ->join('programs', 'schools.id', '=', 'programs.school_id')
            ->where(function ($query) use ($search) {
                $query->where('schools.name', 'like', $search)
                    ->orWhere('programs.event_name', 'like', $search);
            })
            ->where('programs.pledging_start', '<', Carbon::now())
            ->where('programs.pledging_end', '>', Carbon::now())
            ->where('programs.archived', '=', 0)
            ->where('programs.deleted', '=', 0)
            ->where(function ($query) use ($isGivingMarketProgram, $program_type) {
                if ($isGivingMarketProgram) {
                    return $query->where('programs.program_type_id', '=', $program_type->id);
                } else {
                    return $query->where('programs.program_type_id', '!=', $program_type->id)
                        ->orWhere('programs.program_type_id', '=', null);
                }
            })
            ->whereIn('programs.id', function ($query) {
                $query->select('groups.program_id')
                ->from('groups')
                ->join('classrooms', 'classrooms.group_id', '=', 'groups.id')
                ->where('classrooms.deleted', '!=', 1);
            })
            ->distinct('programs.id')
            ->get();
    }

    /**
     * Search for a school by the registration code.  Currently return an exact match
     *
     * @param String Registration code
     * @return App\Entities\School Collection of schools with school name, city state and program registration code.
     */
    public static function searchSchoolByRegistrationCode(String $code)
    {
        //clean the registration code
        $code = filter_var(trim($code), FILTER_SANITIZE_STRING);
        return DB::table('schools')
            ->join('programs', 'schools.id', '=', 'programs.school_id')
            ->leftJoin('program_pledge_settings', 'programs.id', '=', 'program_pledge_settings.program_id')
            ->select(
                'programs.id as program_id',
                'schools.id as school_id',
                'schools.name',
                'schools.city',
                'schools.state',
                'programs.registration_code',
                'program_pledge_settings.family_pledging_enabled',
                'programs.ssv_disabled'
            )
            ->where('programs.archived', '=', 0)
            ->where('programs.deleted', '=', 0)
            ->where('programs.registration_code', $code)
            ->where('programs.pledging_start', '<', Carbon::now())
            ->where('programs.pledging_end', '>', Carbon::now())
            ->whereIn('programs.id', function ($query) {
                $query->select('groups.program_id')
                ->from('groups')
                ->join('classrooms', 'classrooms.group_id', '=', 'groups.id')
                ->where('classrooms.deleted', '!=', 1);
            })
            ->first();
    }
}
