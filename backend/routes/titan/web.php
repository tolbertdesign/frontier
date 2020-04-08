<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/v3', 301);
Route::prefix('v3')->group(function () {
    Route::get('oauth/redirect/{provider}/{userType?}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{provider}', 'Auth\OAuthController@redirectFromProvider');
    Route::post('oath/completeRegistration', 'Auth\OAuthController@completeRegistration')
        ->name('complete_social_register');
    Route::get('classic-signup-registration', 'DashboardController@classicSignUpRegistration');

    Route::get('email-preferences/{emailToken}', 'DashboardController@emailPreferences');
    Route::post('update-email-preferences', 'DashboardController@updateEmailPreferences')
        ->name('update-email-preferences');

    Route::view('/terms', 'terms');
    Route::get('/', 'Auth\AuthController@welcome');
    Auth::routes();

    Route::get('home/dashboard-user', 'DashboardController@dashboardUser');
    Route::get('home/dashboard/beta', 'DashboardController@dashboardBeta');
    Route::get('tkdashboard/{redirect?}', 'DashboardController@tkindex');
    Route::get('tk-register-participant', 'DashboardController@tkRegisterParticipant');
    Route::get('tk-pledge-complete/{user_id}/{token}', 'DashboardController@tkAfterPledge');

    Route::get('home/teacher-dashboard', 'TeacherDashboardController@dashboard');
    Route::get('home/teacher-dashboard-user', 'TeacherDashboardController@dashboardUser');
    Route::get('register/participant', 'ParticipantController@registerView');
    Route::get('register/teacher', 'TeacherController@registerView');
    Route::post('/register/participant', 'ParticipantController@register');
    Route::post('/password/change', 'Auth\UpdatePasswordController@change');
    Route::post('/pledge/reminder/{pledgeId}', 'PledgeController@reminder');

    Route::post('/parent/update', 'ParentController@update');
    Route::post('/participant/update', 'ParticipantController@update');

    Route::get('/logout', function () {
        if (Auth::check()) {
            Auth::logout();
        }
        return redirect('/v3');
    });

    Route::prefix('api')->group(function () {
        Route::get(
            '/registration/validate_teacher_code/{registrationCode}',
            'Auth\RegisterController@validateTeacherRegistrationCode'
        );
        Route::get('validate-profile-complete', 'Auth\RegisterController@validateProfileComplete');
        Route::get('/videos/program/{participantUserId}', 'ParticipantController@getProgramVideos');
        Route::get('/videos/character/{programId}', 'ParticipantController@getCharacterVideos');
        Route::get('/videos/get-pledges/{program}', 'ParticipantController@getGetPledgesVideo');
        Route::get('/business-leaderboard-pledges/{programId}', 'ParticipantController@getBusinessLeaderboardPledges');
        Route::post('/previous-contact-enroll', 'EasyEmailerController@sendToContact');
        Route::post('/enroll-contacts', 'EasyEmailerController@enrollContacts');
        Route::post('/delete-contact', 'EasyEmailerController@deleteContact');
        Route::get(
            'programs/classroom-pledge-totals/{programId}',
            'ProgramController@getProgramClassroomsWithPledgeTotals'
        );
        Route::get('/programs-total-pledged/{programId}', 'ProgramController@getTotalPledged');
        Route::get('/participant/manualPaymentTotal/{participantUser}', 'ManualPaymentTotalController@show');
        Route::get('/report/class-pledge', 'ReportController@getClassPledgeUrl');

        Route::put('/user-task/{user_task}', 'UserTaskController@update')->where('id', '[0-9]+');
        Route::put('/users/{id}', 'ParticipantController@updateUnits')->where('id', '[0-9]+');
        Route::put('/users/notifications/{notification}', 'NotificationController@update');
    });

    Route::put('/pledges/edit/{pledge}', 'PledgeController@update');
    Route::delete('/pledges/{pledgeId}', 'PledgeController@delete');
    Route::get('home/{route}/{param?}', 'DashboardController@dashboard')->middleware('finishLineEligible');

    Route::get('/support/login', 'SupportController@zendeskLogin')->middleware('auth');
    Route::get('/support', 'SupportController@redirectToZenDesk');
});
