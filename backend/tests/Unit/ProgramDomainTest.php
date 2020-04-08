<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Entities\Program;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProgramDomainTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test that the URL for the program is correct.
     *
     * @test
     * @return void
     */
    public function getProgramDomainTest()
    {
        $expectedUrl = 'theboosterbash.com';
        $program     = Program::where('name', 'Salesforce Test Active Non Giving Market Event - Bash Unit Type')->first();
        $this->assertEquals($program->unit->domain, $expectedUrl);
    }
}
