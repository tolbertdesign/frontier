<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\Program;
use App\Entities\PledgePeriod;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class UpdateProgramPledgeDatesTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp() : void
    {
        parent::setUp();
        Storage::fake();
        $this->programObj = factory(Program::class)->create(['pep_rally'=>Carbon::now()]);
        $this->currentTime = Carbon::today();
        $this->programObj->pledging_end = '1970-01-01 00:00:00';
    }

    private function createPledgePeriods(int $program_id, Carbon $starting_timestamp)
    {
        $pledgePeriodDataBulk = [];
        $timestamps = [];

        foreach (range(1, 3) as $ordinal) {
            $pledgePeriodData = [];
            $pledgePeriodData['ordinal'] = $ordinal;
            $pledgePeriodData['program_id'] = $program_id;
            $pledgePeriodData['delivery_ts'] = $starting_timestamp->add($ordinal, 'month');
            $timestamps[] = $pledgePeriodData['delivery_ts'] ;

            $pledgePeriodDataBulk[] = $pledgePeriodData;
        }

        PledgePeriod::insert($pledgePeriodDataBulk);

        return $timestamps;
    }

    public function testPledgingStartUpdated()
    {
        $this->programObj->pledging_start = null;
        $this->programObj->save();

        $this->createPledgePeriods($this->programObj->id, $this->currentTime);
        Artisan::call('command:update_program_pledge_dates');

        $programStartDate = Carbon::parse(Program::find($this->programObj->id)->pledging_start);
        $pepRallyExpectedDate = Carbon::parse($this->programObj->pep_rally)->subWeek()->format('Y-m-d H:i:s');
        $this->assertTrue($programStartDate->format('Y-m-d H:i:s') === $pepRallyExpectedDate);
    }

    public function testPledgingEndUpdated()
    {
        $pledgePeriodTimestamps = $this->createPledgePeriods($this->programObj->id, $this->currentTime);
        Artisan::call('command:update_program_pledge_dates');

        $programEndDate = Carbon::parse(Program::find($this->programObj->id)->pledging_end);
        $this->assertTrue($programEndDate->format('Y-m-d H:i:s') === $pledgePeriodTimestamps[sizeof($pledgePeriodTimestamps) - 1]->format('Y-m-d H:i:s'));
    }
}
