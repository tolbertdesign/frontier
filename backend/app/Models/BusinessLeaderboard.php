<?php

namespace App\Models;

use App\Entities\SponsorType;
use App\Entities\Pledge;
use App\Entities\PledgeType;
use App\Entities\Program;
use DB;

class BusinessLeaderboard
{
    private $program;

    public function __construct(Program $program)
    {
        $this->program = $program;
    }

    public function getPledges()
    {
        $businessPledgeTypeId = SponsorType::where('sponsor_type', 'Business')->first()->id;
        $businessPledges   = Pledge::where(
            [
                'program_id'       => $this->program->id,
                'sponsor_type_id'  => $businessPledgeTypeId,
                'anon'             => '0',
                'pledges.deleted'  => '0'
            ]
        )

            ->join('users', 'users.id', '=', 'pledges.participant_user_id')
            ->join('pledge_types', 'pledge_types.id', '=', 'pledges.pledge_type_id')
            ->join('programs', 'programs.id', '=', 'pledges.program_id')
            ->select(
                [
                    DB::raw('min(pledges.program_id) AS program_id'),
                    DB::raw('min(pledges.business_name) AS business_name'),
                    DB::raw('min(pledges.business_website) AS business_website'),
                    DB::raw('min(pledges.comment) AS comment'),
                    DB::raw('min(pledges.pledge_type_id) AS pledge_type_id'),
                    DB::raw('min(pledges.show_comment) AS show_comment'),
                    DB::raw('min(users.laps) AS laps'),
                    DB::raw('sum(amount) AS amount'),
                    DB::raw('
                        SUM(IF(`pledge_types`.`id` = ' . PledgeType::FLAT . ',
                            `pledges`.`amount`,
                            `pledges`.`amount` * IF(users.laps = 0 OR users.laps IS NULL,
                            `programs`.`unit_flat_conversion`,
                            `users`.`laps`))) AS total_est
                        '),
                ]
            )
            ->groupBy(
                [
                    DB::raw('COALESCE(`pledges`.`family_pledge_id`, `pledges`.`id`)')
                ]
            )
            ->orderBy('total_est', 'desc')
            ->get();

        return $businessPledges;
    }
}
