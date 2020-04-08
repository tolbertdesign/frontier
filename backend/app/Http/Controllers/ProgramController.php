<?php

namespace App\Http\Controllers;

use App\Entities\School;
use App\Entities\Program;
use App\Entities\Classroom;
use Exception;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Requests\HasParticipantInProgramRequest;

class ProgramController extends Controller
{
    /**
     * Searches for a school for user registration
     * @param search search string
     * @return string name A string of the school name
     * @return string city A string of the school city
     * @return string state A string of the school state
     * @return string registration_code A string for the registration code for the program
     */
    public function searchActiveSchools(String $search, Bool $isGivingMarketProgram = false)
    {
        try {
            $results  = School::searchSchoolByName($search, $isGivingMarketProgram);
            return response()->json($results);
        } catch (Exception $e) {
            //Logging errors and returning a general error to production.
            Log::warn(static::class . '->searchActiveSchools failed: ' . $e->getMessage());
            return response()->json(['error' => Lang::get('general.general_error')]);
        }
    }

    /**
     * Queries a program based on the registration code
     * @param search search string
     * @return string name A string of the school name
     * @return string city A string of the school city
     * @return string state A string of the school state
     * @return string registration_code A string for the registration code for the program
     */
    public function searchRegistrationCode(String $search)
    {
        $code = str_replace('-', '', $search);
        try {
            $school = School::searchSchoolByRegistrationCode($code);
            if ($school) {
                $school->classrooms = Program::where('registration_code', $code)
                    ->first()
                    ->classrooms()->with('grade')
                    ->orderBy('grade_id', 'asc')
                    ->orderBy('name', 'asc')
                    ->get();
                return response()->json($school);
            }
            return response()->json(['error' => Lang::get('register.invalid_code')]);
        } catch (Exception $e) {
            //catch any errors, log and return a general message to production
            Log::warn(static::class . '->searchRegistrationCode failed: ' . $e->getMessage());
            return response()->json(['error' => Lang::get('general.general_error')]);
        }
    }

    /**
     * Get the classrooms for a program along with the total pledges
     *
     * @param  Request  $request
     * @return  Collection
     */
    public function getProgramClassroomsWithPledgeTotals(HasParticipantInProgramRequest $request)
    {
        $classrooms = Classroom::withPledgeTotals($request->programId)->get();

        return response()->json($classrooms);
    }

    public function getTotalPledged(HasParticipantInProgramRequest $request)
    {
        $program = Program::find($request->programId)->append('total_pledged');

        return response()->json($program->totalPledged);
    }
}
