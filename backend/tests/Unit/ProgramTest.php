<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Entities\Program;
use Illuminate\Support\Carbon;

class ProgramTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDaysUntilEventAccurate()
    {
        $program                = Program::find(1);
        $expectedDaysUntilEvent = 10;
        $program->fun_run       = Carbon::now()->addDays(10);
        $daysUntilEvent         = $program->daysUntilEvent();
        $this->assertEquals($expectedDaysUntilEvent, $daysUntilEvent);
    }
}
