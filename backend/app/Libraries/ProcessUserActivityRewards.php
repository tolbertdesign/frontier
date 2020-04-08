<?php

namespace App\Libraries;

use App\Entities\PrizesBoundStudent;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Entities\User;
use App\Entities\UserActivity;
use App\Entities\UserActivityHistory;
use App\Models\FamilyPledging;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class ProcessUserActivityRewards implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $participantUser;
    private $userActivities;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $participantUser, Collection $userActivities)
    {
        $this->participantUser = $participantUser;
        $this->userActivities  = $userActivities;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $familyPledging   = new FamilyPledging();
            $participantUsers = $familyPledging->participants($this->participantUser);
            $userActivities   = $this->userActivities;

            $participantUsers->each(function ($participantUser) use ($userActivities) {
                $this->updateUserActivitiesHistory($participantUser, $userActivities);
                $this->awardPrizes($participantUser, $userActivities);
            });
        } catch (Exception $e) {
            $userActivities = implode(', ', $this->userActivities->pluck('name')->all());
            $participantId  =  $this->participantUser->id;
            Log::error('Failed to award activity reward (' . $userActivities . ') for user: ' . $participantId);
            Log::error($e);
        }
    }

    /**
     * Award a user activity prize for a participantUser.
     *
     * @param  App\Entities\User  $participantUser
     * @param  Collection (App\Entities\UserActivity)  $userActivities
     * @return  void
     */
    private function awardPrizes($participantUser, $userActivities)
    {
        PrizesBoundStudent::join('prizes_bound', 'prizes_bound.prize_id', '=', 'prizes_bound_student.prize_id')
            ->where('prizes_bound.group_id', $participantUser->classroom->first()->group_id)
            ->whereIn('prizes_bound.activity_reward', $userActivities->pluck('id')->all())
            ->where('prizes_bound_student.student_id', $participantUser->id)
            ->where('prizes_bound_student.status', PrizesBoundStudent::STATUS_UNASSIGNED)
            ->update([
                'prizes_bound_student.status' => PrizesBoundStudent::STATUS_GIVEAWAY
            ]);
    }

    /**
     * Ensure user activity history is created for the participant.
     *
     * @param  App\Entities\User  $participantUser
     * @param  App\Entities\UserActivity  $userActivities
     * @return  void
     */
    private function updateUserActivitiesHistory($participantUser, $userActivities)
    {
        foreach ($userActivities as $userActivity) {
            UserActivityHistory::firstOrCreate([
                'user_id'     => $participantUser->id,
                'activity_id' => $userActivity->id
            ]);
        }
    }
}
