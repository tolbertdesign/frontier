<?php

namespace App\Http\Controllers;

use App\Entities\Classroom;
use App\Entities\User;
use App\Entities\Program;
use App\Entities\ProgramVideos;
use App\Entities\CharacterVideos;
use App\Http\Requests\CreateParticipantRequest;
use App\Http\Requests\UpdateParticipantRequest;
use App\Models\RegisterModel;
use App\Libraries\FrCodeGenerator;
use App\Libraries\Facebook;
use Auth;
use DB;
use Log;
use Mail;
use Exception;
use \Carbon\Carbon;
use App\Mail\StudentRegistrationEmail;
use App\Models\BusinessLeaderboard;
use App\Entities\Microsite;
use App\Jobs\ClearFacebookCache;
use App\Models\FamilyPledging;
use App\Http\Requests\UpdateParticipantUnitsRequest;
use Illuminate\Http\Request;
use App\Http\Response\View\Welcome;
use Illuminate\Support\Facades\Session;

class ParticipantController extends Controller
{
    private $characterVideosEntity;

    public function __construct(CharacterVideos $characterVideos)
    {
        $this->middleware('auth');
        $this->characterVideosEntity = $characterVideos;
    }

    /**
     * Requires authenticated parent for Auth::user to be parent
     * [
     *   @string 'firstName'
     *   @string 'lastName'
     *   @int    'classroomId'
     *   @bool   'isFamilyPledgingEnabled'
     *   @bool   'isAgreed'
     * ]
     *
     * @return void
     */
    public function register(CreateParticipantRequest $request)
    {
        try {
            $registration = new RegisterModel();
            $user         = User::create([
                'first_name'                 => $request->firstName,
                'last_name'                  => $request->lastName,
                'username'                   => '',
                'password'                   => '',
                'created_on'                 => Carbon::now()->timestamp,
                'waiver_dob'                 => Auth::user()->dob,
                'waiver_ts'                  => Carbon::now(),
                'waiver_signed'              => 1,
                'flagging_mode_id'           => 1,
                'block_collection_reminder'  => 0,
                'reg_code_temp_user'         => 0,
                'email_opt_out'              => 0,
                'fr_code'                    => FrCodeGenerator::generate()
            ]);

            $classroom   = Classroom::findOrFail($request->classroomId);

            $registration->createParticipant(
                $user,
                Auth::user(),
                $classroom,
                $registration->setFamilyPledgingStatusForParticipant(Auth::user(), $classroom->group->program),
                $request->imageFile
            );

            //Now that the participant is setup activate the user
            $user->waiver_dob    = Auth::user()->dob;
            $user->waiver_signed = 1;
            $user->active        = 1;
            $user->registered    = 1;
            $user->waiver_ts     = Carbon::now();
            $user->save();

            if ($request->imageFile) {
                try {
                    Facebook::executeOpenGraphScrape($user->getCanonicalUrlByFacebookReferrer());
                } catch (Exception $e) {
                    Log::error($e->getMessage());
                }
            }

            //Send the email
            try {
                $url = $request->server('HTTP_HOST');
                Mail::to(Auth::user())
                    ->send(new StudentRegistrationEmail($user, $url, Auth::user()));
            } catch (Exception $e) {
                Log::warning('Failed to send registration email for user: ' . $user->id . ': ' . $e);
            } finally {
                return response()->json($user);
            }
        } catch (Exception $e) {
            DB::rollback();
            Log::Error($e);
            return response()->json('An error has ocurred, please try again.', 500);
        }
    }

    /**
     * Get the program videos for a participant
     *
     * @param int $participantUserId
     *
     * @return array
     */
    public function getProgramVideos($participantUserId)
    {
        $participantUser = User::where('id', $participantUserId)->get();
        $programVideos   = new ProgramVideos($participantUser);

        return $programVideos->getVideos();
    }

    /**
     * Get the character videos for a participant
     *
     * @return array
     */
    public function getCharacterVideos($programId)
    {
        $microsite = Microsite::where('program_id', $programId)
            ->with('program')
            ->first();

        if (isset($microsite->program) && $microsite->program->hide_character_videos !== 1) {
            return $this->characterVideosEntity->getVideos();
        }

        return [];
    }

    /**
     * Get the Get Pledges video for a participant
     *
     * @return object
     */
    public function getGetPledgesVideo(Program $program)
    {
        return $program->microsite->getPledgesVideo();
    }

    /**
     * Get the business leaderboard pledges for a participant
     *
     * @param int $programId
     *
     * @return array
     */
    public function getBusinessLeaderboardPledges($programId)
    {
        $program             = Program::where('id', $programId)->first();
        $businessLeaderboard = new BusinessLeaderboard($program);
        return $businessLeaderboard->getPledges();
    }

    public function update(UpdateParticipantRequest $request)
    {
        $validated = $request->validated();

        $participantUser = User::with(['participantInfo', 'participantInfo.user', 'profile'])->find($validated['participant_id']);

        $participantUser->first_name = $validated['first_name'];
        $participantUser->last_name  = $validated['last_name'];
        $participantUser->save();

        $participantUser->profile->pledge_goal      = round($validated['pledge_goal'], 2);
        $participantUser->profile->pledge_page_text = $validated['pledge_page_text'];

        if (array_key_exists('photoFile', $validated) && is_object($validated['photoFile'])) {
            $participantUser->profile->image_name = $participantUser->participantInfo->uploadImage($validated['photoFile']);
        } elseif (array_key_exists('deleteFile', $validated) && (int)$validated['deleteFile'] === 1 && $participantUser->profile->image_name) {
            $participantUser->participantInfo->deleteImage($participantUser->profile->image_name);
            $participantUser->profile->image_name = null;
            $participantUser->profile->video_url  = null;
        }

        $participantUser->profile->save();

        $participantUser->participantInfo->classroom_id = $validated['classroom_id'];
        $participantUser->participantInfo->save();

        if (array_key_exists('family_pledging_enabled', $validated)) {
            $familyPledging = new FamilyPledging();
            $familyPledging->setFamilyPledging($participantUser, (bool) $validated['family_pledging_enabled']);
        }

        try {
            dispatch(new ClearFacebookCache($participantUser));
        } catch (Exception $e) {
            Log::error('Facebook Update Failure');
            Log::error($e->getMessage());
        }

        return $participantUser;
    }

    /**
     * Update units for a participant
     *
     * @param  UpdateParticipantUnitsRequest $request
     * @return  Boolean
     */
    public function updateUnits(UpdateParticipantUnitsRequest $request, int $participantUserId)
    {
        $units  = $request->input('units');
        User::where('id', $participantUserId)->update([
            'laps' => $units
        ]);

        return 1;
    }

    public function registerView(Request $request)
    {
        $previousUrl = str_replace(url('/'), '', url()->previous());

        if ($previousUrl === '/v3/register/participant') {
            // Fallback to home page if we some how just landed directly on this page
            $previousUrl = '/v3/home/dashboard';
        }
        Session::put('userType', 'Parent');
        $welcomeView = new Welcome($request);
        return $welcomeView->make('school-search', $previousUrl);
    }
}
