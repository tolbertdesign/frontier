<?php

namespace App\Entities;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Mappable;
use Sofa\Eloquence\Eloquence;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Log;
use Exception;
use App\Entities\Participant;

class Pledge extends Model
{
    use Mappable;
    use Eloquence;
    use SoftDeletes;

    const DELETED_AT               = 'ts_deleted';
    const ENTERED_STATUS           = 1;
    const CONFIRMED_STATUS         = 2;
    const PAID_STATUS              = 3;
    const PENDING_STATUS           = 4;
    const DELETED_STATUS           = 5;
    const CANCELLED_STATUS         = 6;
    const ABANDONED_STATUS         = 7;
    const PAID_PENDING_STATUS      = 8;
    const PAYMENT_SCHEDULED_STATUS = 8;
    const STATE_MAP_STATUSES       = [2, 3, 8];
    const REMOVED_MAP_STATES       = ['DC', '']; // '' is here to save another loop to remove empty

    public static $paymentPledgedStatusIds = [
        self::CONFIRMED_STATUS,
        self::PAID_STATUS,
        self::PAID_PENDING_STATUS,
    ];

    public $timestamps = false;

    protected $maps = [
        'deleted_at' => 'ts_deleted'
    ];

    protected $appends =[
        'hasPendingPayment'
    ];

    protected $fillable = [
        'business_name',
        'business_website',
        'amount',
        'comment',
        'show_comment',
        'program_id',
        'pledge_type_id',
    ];

    protected $dates = [
        'deleted_at',
        'ts_deleted',
        'ts_confirmed',
        'ts_updated',
        'ts_completed',
        'ts_entered'
    ];

    protected $casts = [
        'ts_entered' => 'datetime:c'
    ];

    public static function getValidPledgeStatusIds()
    {
        return [
            self::ENTERED_STATUS,
            self::PAID_STATUS,
            self::PENDING_STATUS,
            self::PAID_PENDING_STATUS,
        ];
    }

    public function enteredByUser()
    {
        return $this->belongsTo(User::class, 'entered_by_user_id');
    }

    public function enteredLocations()
    {
        return $this->belongsToMany(EnteredLocation::class, 'pledge_entered_location');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function lastModifiedBy()
    {
        return $this->belongsTo(User::class, 'last_modified_by_id');
    }

    public function referrers()
    {
        return $this->belongsToMany(Referrer::class, 'pledge_referrers');
    }

    public function pledgeSponsor()
    {
        return $this->belongsTo(PledgeSponsor::class);
    }

    public function sponsorType()
    {
        return $this->belongsTo(SponsorType::class);
    }

    public function pledgeStatus()
    {
        return $this->belongsTo(PledgeStatus::class);
    }

    public function pledgeSubstatus()
    {
        return $this->belongsTo(PledgeSubstatus::class);
    }

    public function pledgeType()
    {
        return $this->belongsTo(PledgeType::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function pplAmount()
    {
        if ($this->pledge_type_id == PledgeType::PPL) {
            return $this->amount;
        } else {
            return $this->amount / $this->program->getMultiplier();
        }
    }

    public function flatAmount()
    {
        if ($this->pledge_type_id == PledgeType::FLAT) {
            return (float) $this->amount;
        } else {
            return $this->amount * $this->program->getMultiplier();
        }
    }

    public function flatHighAmount()
    {
        if ($this->pledge_type_id == PledgeType::FLAT) {
            return (float) $this->amount;
        } else {
            return $this->amount * $this->program->getHighMultiplier();
        }
    }

    public function formatAmountForDisplay($amount)
    {
        return '$' . str_replace('.00', '', $amount);
    }

    public function getFlatAmountOrRange()
    {
        if ($this->pledge_type_id == PledgeType::FLAT) {
            return $this->formatAmountForDisplay($this->amount);
        } else {
            $lowPledgeAmount  = $this->amount * $this->program->getLowMultiplier();
            $highPledgeAmount = $this->amount * $this->program->getHighMultiplier();
            return $this->formatAmountForDisplay($lowPledgeAmount) .
                ' to ' .
                $this->formatAmountForDisplay($highPledgeAmount);
        }
    }

    public function getBusinessLeaderboardAmount()
    {
        if ($this->attributes['laps'] != null) {
            return $this->formatAmountForDisplay($this->attributes['total_est']);
        } else {
            return $this->getFlatAmountOrRange();
        }
    }

    public function onlinePendingPayments()
    {
        return $this->belongsToMany(
            OnlinePendingPayment::class,
            'online_pending_payment_pledges',
            'pledge_id',
            'online_pending_payments_id'
        );
    }

    public function ccTransactions()
    {
        return $this->belongsToMany(CcTransaction::class, 'cc_transaction_pledges');
    }

    public function sponsorUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function participantUser()
    {
        return $this->belongsTo(User::class, 'participant_user_id');
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_user_id', 'user_id');
    }

    public function getHasPendingPaymentAttribute()
    {
        return $this->onlinePendingPayments
            ->filter(function ($onlinePendingPayment) {
                return $onlinePendingPayment->deleted === 0;
            })->count() > 0;
    }

    public function getBusinessWebsiteAttribute($businessWebsite)
    {
        $urlParts    = parse_url($businessWebsite);
        if ($businessWebsite && empty($urlParts['scheme'])) {
            $businessWebsite = 'https://' . $businessWebsite;
        }
        return $businessWebsite;
    }

    public function populatePledge($pledgeInfo, $sponsorUser, $participantUser, $classroom)
    {
        try {
            $this->participant_user_id = $participantUser->id;
            $this->program_id          = $classroom->group->program_id;
            $this->group_id            = $classroom->group_id;
            $this->user_id             = $sponsorUser->id;
            $this->pledge_type_id      = 3; //(flat)
            $this->amount              = $pledgeInfo['amount'];
            $this->pledge_status_id    = 2; //-> 3
            $this->pledge_substatus_id = 7; //-> 1 (after pay)
            $this->ts_entered          = Carbon::now();
            $this->ts_confirmed        = Carbon::now();
            $this->ts_updated          = Carbon::now();
            $this->entered_by_user_id  = $sponsorUser->id;
            $this->ip_address          = '127.0.0.1';
            $this->deleted             = false;
            $this->protected           = false;
        } catch (Exception $e) {
            Log::emergency($e->getMessage());
            Log::emergency(print_r($participantUser, true));
            throw $e;
        }
    }

    public function pay($paymentId)
    {
        $this->pledge_status_id = self::PAID_STATUS;
        $this->payment_id       = $paymentId;
        $this->ts_completed     = Carbon::now();
        $this->ts_updated       = Carbon::now();
        $this->save();
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'participant');
    }

    /**
     * Get data for sending reminder email for pledge $pledgeId
     * @param int $pledgeId
     * @param int $parentId
     * @return array
     */
    public static function getDataForReminderEmail(int $pledgeId, int $parentId)
    {
        $where = [];

        // Make sure logged in user is a parent of the participant of the pledge
        $where[] = ['students_parents.parent_id', '=', $parentId];
        $where[] = ['pledges.id', '=', $pledgeId];
        $where[] = ['payments.deleted', '=', '0'];
        $where[] = ['pledges.deleted', '=', '0'];

        $columnsToSelect = [
            'sponsor_user.email as sponsorEmail',
            'sponsor_user.first_name as sponsorFirstName',
            'participant_user.first_name as participantFirstName',
            'programs.event_name as eventName',
            'sponsor_user.fr_code'
        ];

        return DB::table('pledges')
            ->select(...$columnsToSelect)
            ->join('students_parents', 'students_parents.student_id', '=', 'pledges.participant_user_id')
            ->join('users as sponsor_user', 'sponsor_user.id', '=', 'pledges.user_id')
            ->join('users as participant_user', 'participant_user.id', '=', 'pledges.participant_user_id')
            ->join('programs', 'programs.id', '=', 'pledges.program_id')
            ->join('payments', 'payments.id', '=', 'pledges.payment_id')
            ->where($where)->first();
    }

    public static function makeTkPayLink(string $frCode): string
    {
        return secure_url(config('booster.trapper_url') . '/auth/login/' . $frCode . '/0/0/0/paynow');
    }

    public function setPledgeToDeleted()
    {
        $pledgeStatus = PledgeStatus::where('name', 'deleted')->first();

        return Pledge::where('id', $this->id)
            ->orWhere(
                function ($query) {
                    $query->hasFamilyPledgingId()
                        ->where('family_pledge_id', $this->family_pledge_id);
                }
            )
            ->update([
                'pledge_status_id' => $pledgeStatus->id,
                'deleted'          => 1,
                'ts_deleted'       => Carbon::now(),
                'deleted_at'       => Carbon::now(),
            ]);
    }

    public function scopeHasFamilyPledgingId($query)
    {
        return $query->where('family_pledge_id', '!=', null);
    }
}
