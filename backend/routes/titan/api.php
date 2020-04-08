<?php

use Illuminate\Http\Request;
use App\Entities\School;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v3')->group(function () {
    Route::get('public_pledges/{program_id}', 'PublicController@pledges');
});

Route::get('/schools/{search}', function ($search) {
    return School::searchSchoolByName($search, false);
});
Route::get('/schools/registration-code/{code}', 'ProgramController@searchRegistrationCode');
Route::post('/register/email-address', 'Auth\RegisterController@validateEmailAddress');
Route::post('email/student-star-video-ready', 'EmailController@studentStarVideoReady');
Route::delete('/users/notifications/destroyByProgram/{token}/{programId}', 'NotificationController@destroyByProgram')->where('programId', '[0-9]+');
Route::post('/users/notifications/storeByProgram/{token}/{programId}', 'NotificationController@storeByProgram')->where('programId', '[0-9]+');
