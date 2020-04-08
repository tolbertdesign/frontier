<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Entities\Pledge;
use App\Entities\PledgeType;
use App\Libraries\CacheKeys;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class Program extends Model
{
    private $flatTotal = null;
    public $timestamps = false;

    protected $casts = [
        'sponsor_convenience_fee' => 'float',
        'fun_run'                 => 'datetime:c'
    ];

    protected $appends =[
        'pledgedPlaces',
        'decoded_event_name'
    ];

    public function classrooms()
    {
        return $this->hasManyThrough(Classroom::class, Group::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function pledgePeriods()
    {
        return $this->hasMany(PledgePeriod::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function emailNotifications()
    {
        return $this->hasMany(EmailNotification::class);
    }

    public function paymentNotifies()
    {
        return $this->hasMany(PaymentNotify::class);
    }

    public function customProgramAlert()
    {
        return $this->hasMany(CustomProgramAlert::class);
    }

    public function programPledgeSetting()
    {
        return $this->hasOne(ProgramPledgeSetting::class)->withDefault(
            ProgramPledgeSetting::getAllDefaultValues()
        );
    }

    public function getProgramPledgeSetting()
    {
        return is_null($this->programPledgeSetting) ? new ProgramPledgeSetting() : $this->programPledgeSetting;
    }

    public function collectionReminderHistories()
    {
        return $this->hasMany(CollectionReminderHistory::class);
    }

    public function programTodos()
    {
        return $this->hasMany(ProgramTodo::class);
    }

    public function s3Reports()
    {
        return $this->hasMany(S3Report::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function microsite()
    {
        return $this->hasOne(Microsite::class);
    }

    public function getMultiplier()
    {
        return 30;
    }

    public function getLowMultiplier()
    {
        return 30;
    }

    public function getHighMultiplier()
    {
        return 35;
    }

    public function pledges()
    {
        return $this->hasMany(Pledge::class);
    }

    public function userTasks()
    {
        return $this->hasMany(UserTask::class);
    }

    public function programSponsors()
    {
        return $this->belongsToMany(ProgramSponsor::class, 'programs_program_sponsors');
    }

    public function flatTotal($pledgeStatuses = [])
    {
        $pledgeStatuses = (empty($pledgeStatuses)) ? Pledge::getValidPledgeStatusIds() : $pledgeStatuses;

        if ($this->flatTotal === null) {
            $this->flatTotal = DB::table('pledges')
                ->selectRaw(
                    'sum(IF(pledges.pledge_type_id = ?, pledges.amount, pledges.amount*?)) as sum',
                    [PledgeType::FLAT, $this->getMultiplier()]
                )
                ->where('pledges.program_id', '=', $this->id)
                ->whereIn('pledges.pledge_status_id', $pledgeStatuses)->first()->sum;
        }
        return $this->flatTotal;
    }

    public function percentToGoal()
    {
        if ($this->client_goal && $this->client_percent) {
            return floor($this->clientFlatTotal() / $this->client_goal * 100);
        } else {
            return 0;
        }
    }

    public function clientFlatTotal()
    {
        $flatTotalPledgeStatuses = [
            Pledge::CONFIRMED_STATUS,
            Pledge::PAID_STATUS,
            Pledge::PAID_PENDING_STATUS,
        ];
        return $this->flatTotal($flatTotalPledgeStatuses) * ($this->client_percent / 100);
    }

    public function daysUntilEvent()
    {
        $todaysDate = Carbon::today();
        $funRun     = new Carbon($this->fun_run);
        return $todaysDate->diffInDays($funRun, false);
    }

    public function getTheme()
    {
        if ($this->microsite &&
            $this->microsite->micrositeColorTheme &&
            $this->microsite->micrositeColorTheme->theme_name) {
            return $this->microsite->micrositeColorTheme->theme_name;
        }
        return 'default_theme';
    }

    public function validatePaymentSettings()
    {
        if (! $this->school->braintreeMerchant()->exists()) {
            return false;
        }
        $isActiveMerchant = $this->school->braintreeMerchant->status === 'active';
        $isPaymentEnabled = $this->online_payment_enabled === 1;
        return $isActiveMerchant && $isPaymentEnabled;
    }

    public function getSponsorConvenienceFeeAttribute($val)
    {
        return $val === null ? 0 : $val;
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
                ->where('groups.program_id', '=', $this->id)
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
                ->where('groups.program_id', '=', $this->id)
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

    /**
     * Get the distinct user ids associated with the program that have dashboards.
     *
     * @return  Array
     */
    public function getDashboardUserIds()
    {
        return User::select('users.id')
            ->distinct()
            ->join('students_parents', 'students_parents.parent_id', '=', 'users.id')
            ->join('participants', 'students_parents.student_id', '=', 'participants.user_id')
            ->join('classrooms', 'classrooms.id', '=', 'participants.classroom_id')
            ->join('groups', 'groups.id', '=', 'classrooms.group_id')
            ->where('groups.program_id', $this->id)
            ->nonDeleted()
            ->get()
            ->pluck('id')
            ->toArray();
    }

    public function getTotalPledgedAttribute()
    {
        $record = Pledge::select(DB::raw(
            'SUM(
                IF(pledge_type_id != ' . PledgeType::FLAT . ',
                    (amount * programs.unit_flat_conversion)
                , amount)
            ) AS confirmed_total'
        ))
            ->join('users', 'users.id', '=', 'pledges.participant_user_id')
            ->join('pledge_types', 'pledge_types.id', '=', 'pledges.pledge_type_id')
            ->join('programs', 'programs.id', '=', 'pledges.program_id')
            ->where('pledges.program_id', $this->id)
            ->whereIn('pledges.pledge_status_id', [
                Pledge::CONFIRMED_STATUS,
                Pledge::PAID_STATUS,
                Pledge::PAID_PENDING_STATUS
            ])->get();

        return (float)$record[0]->confirmed_total;
    }

    public function getDecodedEventNameAttribute()
    {
        return html_entity_decode($this->event_name);
    }

    /**
     * Scope a query to only include active programs.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->nonDeleted()->nonArchived();
    }

    /**
     * Scope a query to not include deleted programs.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNonDeleted($query)
    {
        return $query->where('programs.deleted', '!=', 1);
    }

    /**
     * Scope a query to not include archived programs.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNonArchived($query)
    {
        return $query->where('programs.archived', '!=', 1);
    }

    /**
     * Get the program cache.
     *
     * @return  Array
     */
    public function getProgramUserIdsFromCache()
    {
        return Cache::rememberForever(CacheKeys::getDashboardUserIdsByProgramId($this->id), function () {
            return $this->getDashboardUserIds();
        });
    }
}
