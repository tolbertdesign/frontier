<?php

namespace App\Http\Controllers;

use App\Entities\Notification;
use App\Entities\Program;
use App\Libraries\CacheKeys;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Http\Requests\NotificationRequest;
use App\Http\Requests\InternalAccessTokenRequest;
use App\Jobs\CreateNotificationsByProgram;
use App\Jobs\DeleteNotificationByProgram;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Facades\FeatureFlag;

class NotificationController extends Controller
{
    public function __construct()
    {
        if (FeatureFlag::checkIfGloballyEnabled('notifications') === false) {
            abort(404);
        }
    }

    /**
     * Store a newly created notifications for a program.
     *
     * @param  int  $programId
     * @return \Illuminate\Http\Response
     */
    public function storeByProgram(InternalAccessTokenRequest $request, $token, int $programId)
    {
        try {
            $program = Program::find($programId);
            CreateNotificationsByProgram::dispatch($program);
        } catch (Exception $e) {
            Log::warning($e);
            return 'false';
        }

        return 'true';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\NotificationRequest  $request
     * @param  \App\Entities\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(NotificationRequest $request, Notification $notification)
    {
        try {
            $userId   = Auth::id();
            $cacheKey = CacheKeys::getUserNotificationKey($userId);
            Cache::forget($cacheKey);

            $notification->read_at = Carbon::now();
            $notification->save();
        } catch (Exception $e) {
            Log::warning($e);
            return 'false';
        }

        return $notification;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $programId
     * @return \Illuminate\Http\Response
     */
    public function destroyByProgram(InternalAccessTokenRequest $request, $token, int $programId)
    {
        $type = Notification::TYPE_PROGRAM;
        $program = Program::find($programId);
        DeleteNotificationByProgram::dispatch($program, $type);
    }
}
