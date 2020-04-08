<?php

namespace App\Entities;

use Exception;
use Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Entities\PotentialSponsor;
use App\Models\UploadImageModel;
use App\Models\StudentStarModel;

class Participant extends Model
{
    public $timestamps = false;

    public $fillable = [
        'classroom_id',
        'user_id',
        'family_pledging_enabled',
        'allow_pay_later_override',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function potentialSponsors()
    {
        return $this->hasMany(PotentialSponsor::class, 'participant_user_id', 'user_id');
    }

    public function prizeBoundStudents()
    {
        return $this->hasMany(PrizesBoundStudent::class, 'student_id', 'user_id');
    }

    public function pledges()
    {
        return $this->hasMany(Pledge::class, 'participant_user_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specialUrls()
    {
        return $this->hasMany(SpecialUrl::class);
    }

    /**
     * Retrieves the program that the participant is in
     *
     * @return App\Entities\Program
     */
    public function program()
    {
        return $this->classroom->group->program;
    }

    public function ppuFormatted()
    {
        $pplTotal = $this->pplTotal();
        if ($pplTotal == floor($pplTotal)) {
            return number_format($pplTotal, 0);
        } else {
            return number_format($pplTotal, 2);
        }
    }

    public function pplTotal()
    {
        $program_multiplier = $this->classroom->group->program->getMultiplier();
        $ppl_total          = DB::table('pledges')
            ->selectRaw(
                'sum(IF(pledges.pledge_type_id = ?, pledges.amount/?, pledges.amount)) as sum',
                [PledgeType::FLAT, $program_multiplier]
            )
            ->where('pledges.participant_user_id', '=', $this->user->id)
            ->whereIn(
                'pledges.pledge_status_id',
                [Pledge::CONFIRMED_STATUS,
                    Pledge::PAID_STATUS,
                    Pledge::PENDING_STATUS,
                    Pledge::PAID_PENDING_STATUS]
            )
            ->where('pledges.deleted', 0)
            ->first();

        return $ppl_total->sum;
    }

    public function flatFormatted()
    {
        $flatTotal = $this->flatTotal();
        if ($flatTotal == floor($flatTotal)) {
            return number_format($flatTotal, 0);
        } else {
            return number_format($flatTotal, 2);
        }
    }

    public function flatTotal()
    {
        $program_multiplier  = $this->classroom->group->program->getMultiplier();
        $flat_total          = DB::table('pledges')
            ->selectRaw(
                'sum(IF(pledges.pledge_type_id = ?, pledges.amount*?, pledges.amount)) as sum',
                [PledgeType::PPL, $program_multiplier]
            )
            ->where('pledges.participant_user_id', '=', $this->user->id)
            ->whereIn(
                'pledges.pledge_status_id',
                [Pledge::CONFIRMED_STATUS,
                    Pledge::PAID_STATUS,
                    Pledge::PENDING_STATUS,
                    Pledge::PAID_PENDING_STATUS]
            )
            ->where('pledges.deleted', 0)
            ->first();

        return $flat_total->sum;
    }

    public function percentToGoal()
    {
        $programPledgeSettings = $this->classroom->group->program->getProgramPledgeSetting();
        $pledgeGoal            = (float) $this->user->profile->pledge_goal;

        if ($programPledgeSettings->flat_donate_only) {
            $totalPledges = $this->flatTotal();
        } else {
            $totalPledges = $this->pplTotal();
        }
        return empty($pledgeGoal) ? 0 : $totalPledges / $pledgeGoal * 100;
    }

    public function uploadImage($imageFile)
    {
        $uploadImageModel = new UploadImageModel();
        $imageName        = $uploadImageModel->uploadParticipantImage($imageFile, $this->user_id);

        $program = $this->program();

        if ($imageName && ! $program->ssv_disabled) {
            $imageUrl         = $this->user->makeUserProfileImageUrl($imageName);
            $studentStarModel = new StudentStarModel();
            $studentStarModel->createJob(
                $imageUrl,
                $this->user->id,
                $this->user->first_name,
                $this->user->getProgram()->event_name
            );
        }

        return $imageName;
    }

    public function deleteImage($imageName)
    {
        try {
            $uploadImageModel = new UploadImageModel();
            $uploadImageModel->deleteParticipantImage($imageName);
        } catch (Exception $e) {
            // Possible when a file doesn't exist which we are attempting to delete
            Log::error($imageName . ' - delete error ' . $e);
        }

        $studentStarModel = new StudentStarModel();
        $studentStarModel->cancelJobsBy($this->user->id);
    }
}
