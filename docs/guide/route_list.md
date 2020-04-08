---
title: Route  List
---
## Routes

| Method   | URI                                                             | Action                                                  | Middleware                  |
|----------|-----------------------------------------------------------------|---------------------------------------------------------|-----------------------------|
| GET,HEAD | v3                                                              | Auth\AuthController@welcome                             | web                         |
| GET,HEAD | v3/api/business-leaderboard-pledges/{programId}                 | ParticipantController@getBusinessLeaderboardPledges     | web,auth                    |
| POST     | v3/api/delete-contact                                           | EasyEmailerController@deleteContact                     | web,auth                    |
| POST     | v3/api/email/student-star-video-ready                           | EmailController@studentStarVideoReady                   | api                         |
| POST     | v3/api/enroll-contacts                                          | EasyEmailerController@enrollContacts                    | web,auth                    |
| GET,HEAD | v3/api/participant/manualPaymentTotal/{participantUser}         | ManualPaymentTotalController@show                       | web                         |
| POST     | v3/api/previous-contact-enroll                                  | EasyEmailerController@sendToContact                     | web,auth                    |
| GET,HEAD | v3/api/programs-total-pledged/{programId}                       | ProgramController@getTotalPledged                       | web                         |
| GET,HEAD | v3/api/programs/classroom-pledge-totals/{programId}             | ProgramController@getProgramClassroomsWithPledgeTotals  | web                         |
| POST     | v3/api/register/email-address                                   | Auth\RegisterController@validateEmailAddress            | api                         |
| GET,HEAD | v3/api/registration/validate_teacher_code/{registrationCode}    | Auth\RegisterController@validateTeacherRegistrationCode | web,auth                    |
| GET,HEAD | v3/api/report/class-pledge                                      | ReportController@getClassPledgeUrl                      | web                         |
| GET,HEAD | v3/api/schools/registration-code/{code}                         | ProgramController@searchRegistrationCode                | api                         |
| GET,HEAD | v3/api/schools/{search}                                         | Closure                                                 | api                         |
| GET,HEAD | v3/api/user                                                     | Closure                                                 | api,auth:api                |
| PUT      | v3/api/user-task/{user_task}                                    | UserTaskController@update                               | web                         |
| DELETE   | v3/api/users/notifications/destroyByProgram/{token}/{programId} | NotificationController@destroyByProgram                 | api                         |
| POST     | v3/api/users/notifications/storeByProgram/{token}/{programId}   | NotificationController@storeByProgram                   | api                         |
| PUT      | v3/api/users/notifications/{notification}                       | NotificationController@update                           | web                         |
| PUT      | v3/api/users/{id}                                               | ParticipantController@updateUnits                       | web,auth                    |
| GET,HEAD | v3/api/validate-profile-complete                                | Auth\RegisterController@validateProfileComplete         | web                         |
| GET,HEAD | v3/api/videos/character/{programId}                             | ParticipantController@getCharacterVideos                | web,auth                    |
| GET,HEAD | v3/api/videos/get-pledges/{program}                             | ParticipantController@getGetPledgesVideo                | web,auth                    |
| GET,HEAD | v3/api/videos/program/{participantUserId}                       | ParticipantController@getProgramVideos                  | web,auth                    |
| GET,HEAD | v3/classic-signup-registration                                  | DashboardController@classicSignUpRegistration           | web                         |
| GET,HEAD | v3/email-preferences/{emailToken}                               | DashboardController@emailPreferences                    | web                         |
| GET,HEAD | v3/home/dashboard-user                                          | DashboardController@dashboardUser                       | web,auth                    |
| GET,HEAD | v3/home/dashboard/beta                                          | DashboardController@dashboardBeta                       | web                         |
| GET,HEAD | v3/home/teacher-dashboard                                       | TeacherDashboardController@dashboard                    | web,auth                    |
| GET,HEAD | v3/home/teacher-dashboard-user                                  | TeacherDashboardController@dashboardUser                | web,auth                    |
| GET,HEAD | v3/home/{route}/{param?}                                        | DashboardController@dashboard                           | web,finishLineEligible,auth |
| POST     | v3/login                                                        | Auth\LoginController@login                              | web,guest                   |
| GET,HEAD | v3/login                                                        | Auth\LoginController@showLoginForm                      | web,guest                   |
| GET,HEAD | v3/logout                                                       | Closure                                                 | web                         |
| POST     | v3/logout                                                       | Auth\LoginController@logout                             | web                         |
| POST     | v3/oath/completeRegistration                                    | Auth\OAuthController@completeRegistration               | web                         |
| GET,HEAD | v3/oauth/redirect/{provider}/{userType?}                        | Auth\OAuthController@redirectToProvider                 | web                         |
| GET,HEAD | v3/oauth/{provider}                                             | Auth\OAuthController@redirectFromProvider               | web                         |
| POST     | v3/parent/update                                                | ParentController@update                                 | web                         |
| POST     | v3/participant/update                                           | ParticipantController@update                            | web,auth                    |
| POST     | v3/password/change                                              | Auth\UpdatePasswordController@change                    | web                         |
| POST     | v3/password/email                                               | Auth\ForgotPasswordController@sendResetLinkEmail        | web,guest                   |
| GET,HEAD | v3/password/reset                                               | Auth\ForgotPasswordController@showLinkRequestForm       | web,guest                   |
| POST     | v3/password/reset                                               | Auth\ResetPasswordController@reset                      | web,guest                   |
| GET,HEAD | v3/password/reset/{token}                                       | Auth\ResetPasswordController@showResetForm              | web,guest                   |
| POST     | v3/pledge/reminder/{pledgeId}                                   | PledgeController@reminder                               | web                         |
| PUT      | v3/pledges/edit/{pledge}                                        | PledgeController@update                                 | web                         |
| DELETE   | v3/pledges/{pledgeId}                                           | PledgeController@delete                                 | web                         |
| POST     | v3/register                                                     | Auth\RegisterController@register                        | web                         |
| GET,HEAD | v3/register                                                     | Auth\RegisterController@showRegistrationForm            | web                         |
| POST     | v3/register/participant                                         | ParticipantController@register                          | web,auth                    |
| GET,HEAD | v3/register/participant                                         | ParticipantController@registerView                      | web,auth                    |
| GET,HEAD | v3/register/teacher                                             | TeacherController@registerView                          | web                         |
| GET,HEAD | v3/support                                                      | SupportController@redirectToZenDesk                     | web                         |
| GET,HEAD | v3/support/login                                                | SupportController@zendeskLogin                          | web,auth                    |
| GET,HEAD | v3/terms                                                        | Illuminate\Routing\ViewController                       | web                         |
| GET,HEAD | v3/tk-pledge-complete/{user_id}/{token}                         | DashboardController@tkAfterPledge                       | web                         |
| GET,HEAD | v3/tk-register-participant                                      | DashboardController@tkRegisterParticipant               | web,auth                    |
| GET,HEAD | v3/tkdashboard/{redirect?}                                      | DashboardController@tkindex                             | web,auth                    |
| POST     | v3/update-email-preferences                                     | DashboardController@updateEmailPreferences              | web                         |