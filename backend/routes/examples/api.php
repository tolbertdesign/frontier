<?php

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

// Route::post('/register', 'UserController@register');
Route::post('/register', function (Request $request) {
    // $this->validator($request->all())->validate();
    $data = $request->validate($request->all());

    $user = $this->create($request->all());

    Auth::guard()->login($user);

    return response()->json([
        'user' => $user,
        'message' => 'registration successful'
    ], 200);
});

// Route::post('/login', 'UserController@login');
Route::post('/login', function (Request $request) {
    $data = $request->validate([
        'email' => 'required',
        'password' => 'required',
    ]);
    auth()->attempt($request->only('email', 'password'));
    return auth()->user();
});

// Route::post('/login', function () {
//     $email = Request::get('email');
//     $password = Request::get('password');

//     if (Auth::attempt(['email' => $email, 'password' => $password])) {
//         return response()->json('', 204);
//     } else{
//         return response()->json([
//             'error' => 'invalid_credentials'
//         ], 403);
//     }
// });

// Route::get('/logout', 'UserController@logout');
Route::post('/logout', function (Request $request) {
    auth()->logout();
    // return response('');

    $request->session()->invalidate();
    if ($request->wantsJson()) {
        return response()->json([], 204);
    }
    return redirect('/');
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Task Routes
Route::post('/add-task', 'TaskController@addTask')->middleware('auth:sanctum');
Route::get('/get-task', 'TaskController@getTask')->middleware('auth:sanctum');

// Route::group(['middleware' => 'auth:sanctum'], function () {
//     Route::post('logout', 'Auth\LoginController@logout');
//     Route::get('/user', function (Request $request) {
//         return $request->user();
//     });
//     Route::patch('settings/profile', 'Settings\ProfileController@update');
//     Route::patch('settings/password', 'Settings\PasswordController@update');
// });

// Route::group(['middleware' => 'guest:api'], function () {
//     Route::post('login', 'Auth\LoginController@login');
//     Route::post('register', 'Auth\RegisterController@register');
//     Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
//     Route::post('password/reset', 'Auth\ResetPasswordController@reset');
//     Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
//     Route::post('email/resend', 'Auth\VerificationController@resend');
//     Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
//     Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
// });
