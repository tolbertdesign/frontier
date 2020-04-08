<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class UpdateProgramPledgeDates extends Command
{
    const PLEDGING_END_DEFAULT_DATE = '1970-01-01 00:00:00';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update_program_pledge_dates {pep_rally_after_date=2019-06-01}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates program pledge start & end dates based for programs with a pep_rally date after the pep_rally_after_date';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function getLogFileName()
    {
        return 'command_logs/update_program_pledge_dates_' . date('Y_m_d_h_i_s') . '.csv';
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Convert argument to a date object
        $dateObject = \DateTime::createFromFormat('Y-m-d h:i:s', $this->argument('pep_rally_after_date') . ' 00:00:00');

        // Get programs which hasn't had their pledging_end set & a pep_rally date greater than the pep_rally_after_date
        $programs = DB::table('programs')
            ->select(['programs.*', 'pledge_periods.delivery_ts'])
            ->join(DB::raw('(SELECT MAX(delivery_ts) as delivery_ts, program_id FROM pledge_periods GROUP BY program_id) AS latestPeriod'), 'latestPeriod.program_id', '=', 'programs.id')
            ->join('pledge_periods', function ($join) {
                $join->on('latestPeriod.program_id', '=', 'pledge_periods.program_id');
                $join->on('latestPeriod.delivery_ts', '=', 'pledge_periods.delivery_ts');
            })
            ->where('pep_rally', '>', $dateObject->format('Y-m-d'))
            ->where(function ($query) {
                $query->where('deleted', 0)->orWhereNull('deleted');
            })
            ->where('archived', 0)
            ->where('pledging_end', '=', self::PLEDGING_END_DEFAULT_DATE)
            ->get();

        // Initialize data that will be looged with headers
        $logData = ['program_id' . ',' . 'old_pledging_start' . ',' . 'old_pledging_end' . ',' . 'new_pledging_start' . ',' . 'new_pledging_end'];

        if (! empty($programs)) {
            foreach ($programs as $program) {
                $forLog    = $program->id . ',' . $program->pledging_start . ',' . $program->pledging_end;
                $forUpdate = [];

                if (! isset($program->pledging_start) && isset($program->pep_rally)) {
                    // Set pledging_start to 1 week before pep rally if it hasn't been set
                    $program->pledging_start     = Carbon::parse($program->pep_rally)->subWeek();
                    $forUpdate['pledging_start'] = $program->pledging_start;
                }

                $program->pledging_end     = $program->delivery_ts;
                $forUpdate['pledging_end'] = $program->delivery_ts;

                DB::table('programs')->where('id', $program->id)->update($forUpdate);

                $forLog .= ',' . $program->pledging_start . ',' . $program->pledging_end;
                $logData[] = $forLog;
            }
        }

        Storage::put(
            $this->getLogFileName(),
            implode("\n", $logData)
        );
    }
}
