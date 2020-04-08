<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Entities\School;
use App\Entities\Program;
use App\Entities\Group;
use App\Entities\Classroom;
use Exception;
use App\Http\Controllers\ProgramController;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use Illuminate\Support\Carbon;
use Lang;

class SchoolSearchAPITest extends TestCase
{
    use DatabaseTransactions;

    public function testSchoolSearchApiSuccess()
    {
        $school                  = School::first();
        $program                 = $school->programs->first();
        $program->pledging_start = Carbon::yesterday();
        $program->pledging_end   = Carbon::tomorrow();
        $program->save();

        $search   = 'sal';
        $response = $this->get('/v3/api/schools/' . $search);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            '0' => [
                'city',
                'event_name',
                'name',
                'registration_code',
                'state',
            ]
        ]);
    }

    public function testHasClassSchoolSearch()
    {
        $school     = factory(School::class)->create(['name' => 'testHasClassSchoolSearch School']);
        $program    = factory(Program::class)->create([
            'school_id'       => $school->id,
            'pledging_start'  => Carbon::yesterday(),
            'pledging_end'    => Carbon::tomorrow()
        ]);
        $group      = factory(Group::class)->create(['program_id' => $program->id]);
        $classroom  = factory(Classroom::class)->create([
            'group_id' => $group->id,
            'deleted'  => 0
        ]);

        $response        = $this->get('/v3/api/schools/' . $school->name);
        $foundInResponse = $this->isSchoolInResponse($school->id, $response->getData());

        $this->assertTrue($foundInResponse);
    }

    public function testNoClassSchoolSearch()
    {
        $school     = factory(School::class)->create(['name' => 'testNoClassSchoolSearch School']);
        $program    = factory(Program::class)->create([
            'school_id'      => $school->id,
            'pledging_start' => Carbon::yesterday(),
            'pledging_end'   => Carbon::tomorrow()
        ]);

        $response           = $this->get('/v3/api/schools/' . $school->name);
        $foundInResponse    = $this->isSchoolInResponse($school->id, $response->getData());

        $this->assertFalse($foundInResponse);
    }

    public function testArchivedSchoolSearch()
    {
        $school  = factory(School::class)->create(['name' => 'testArchivedSchoolSearch School']);
        $program = factory(Program::class)->create([
            'school_id'      => $school->id,
            'archived'       => 1,
            'pledging_start' => Carbon::yesterday(),
            'pledging_end'   => Carbon::tomorrow()
        ]);

        $response        = $this->get('/v3/api/schools/' . $school->name);
        $foundInResponse = $this->isSchoolInResponse($school->id, $response->getData());

        $this->assertFalse($foundInResponse);
    }

    private function isSchoolInResponse(int $schoolId, array $responseData)
    {
        $foundInResponse = false;

        if (! empty($responseData)) {
            foreach ($responseData as $schoolResponse) {
                if ($schoolResponse->school_id === $schoolId) {
                    $foundInResponse = true;
                    break;
                }
            }
        }

        return $foundInResponse;
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testSchoolSearchApiExceptionTesting()
    {
        $appEnv = config('app.env');
        config(['app.env' => 'testing']);
        $programController = new ProgramController();
        $search            = 'sal';

        $schoolMock = Mockery::mock('overload:' . School::class);
        $schoolMock->shouldReceive('searchSchoolByName')->andThrow(new Exception);

        $response = $programController->searchActiveSchools($search, true);
        $this->assertStringContainsString('{"error":"An error has occurred please try again."}', $response->content());
        config(['app.env' => $appEnv]);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testSchoolSearchApiException()
    {
        $search = 'sal';

        $schoolMock = Mockery::mock('overload:' . School::class);
        $schoolMock->shouldReceive('searchSchoolByName')->andThrow(new Exception);

        $programController = new ProgramController();
        $response          = $programController->searchActiveSchools($search, true);
        $this->assertStringContainsString(Lang::get('general.general_error'), $response->content());
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testValidSchoolSearchApi()
    {
        $search = 'Sal';

        $programController = new ProgramController();
        $response          = $programController->searchActiveSchools($search, true);

        $this->assertStringContainsString($search, $response->content());
        $this->assertStringNotContainsString(Lang::get('general.general_error'), $response->content());
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRegistrationCodeSearchApiException()
    {
        $search     = 'sal';
        $schoolMock = Mockery::mock('overload:' . School::class);
        $schoolMock->shouldReceive('searchSchoolByRegistrationCode')->andThrow(new Exception);

        $programController = new ProgramController();
        $response          = $programController->searchRegistrationCode($search);
        $this->assertStringContainsString(Lang::get('general.general_error'), $response->content());
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRegistrationCodeSearchApiExceptionTesting()
    {
        $appEnv = config('app.env');
        config(['app.env' => 'testing']);
        $programController = new ProgramController();
        $search            = 'sal';

        $schoolMock = Mockery::mock('overload:' . School::class);
        $schoolMock->shouldReceive('searchSchoolByRegistrationCode')->andThrow(new Exception);

        $response = $programController->searchRegistrationCode($search);
        $this->assertStringContainsString('{"error":"An error has occurred please try again."}', $response->content());
        config(['app.env' => $appEnv]);
    }

    public function testGivingMarketSchoolSearchEntitySuccess()
    {
        $programs = Program::get();
        foreach ($programs as $program) {
            $program->pledging_end = Carbon::tomorrow();
            $program->save();
        }

        // Giving Market programs have a program_type_id of 1
        $givingMarketProgramCount = Program::where('program_type_id', 1)
            ->where('archived', '=', 0)
            ->where('deleted', '=', 0)
            ->where('pledging_start', '<', Carbon::now())
            ->where('pledging_end', '>', Carbon::now())
            ->count();

        $search                = 'sal';
        $isGivingMarketProgram = true;
        $initialResults        = School::searchSchoolByName($search, $isGivingMarketProgram);

        // Add new Giving Market program
        $school = factory(School::class)->create([
            'name' => $search
        ]);
        $program = factory(Program::class)->create([
            'program_type_id' => 1, // Giving Market program type id
            'school_id'       => $school->id,
            'event_name'      => $search,
            'pledging_start'  => Carbon::yesterday(),
            'pledging_end'    => Carbon::tomorrow(),
            'archived'        => 0,
            'deleted'         => 0,
        ]);
        $group = factory(Group::class)->create([
            'program_id' => $program->id
        ]);
        $classroom = factory(Classroom::class)->create([
            'group_id' => $group->id,
            'deleted'  => 0
        ]);

        // Check to make sure new Giving Market program shows up in search results
        $searchResults = School::searchSchoolByName($search, $isGivingMarketProgram);
        $this->assertCount(count($initialResults) + 1, $searchResults);
    }

    public function testProgramRegistrationCodeSearch()
    {
        $school                  = School::first();
        $program                 = $school->programs->first();
        $program->pledging_start = Carbon::yesterday();
        $program->pledging_end   = Carbon::tomorrow();
        $program->save();

        $search   = '123456';
        $response = $this->get('/v3/api/schools/registration-code/' . $search);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'city',
            'classrooms' => [
                '0' => [
                    'id',
                    'name',
                ]
            ],
            'name',
            'registration_code',
            'state',
        ]);
    }
}
