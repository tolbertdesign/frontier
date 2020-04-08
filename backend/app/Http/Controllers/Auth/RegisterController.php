<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Entities\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use App\Models\RegisterModel;
use App\Http\Requests\ValidateEmailAddressRequest;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->only('validateTeacherRegistrationCode');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validator = Validator::make(
            $data,
            [
                'first_name' => 'required|string|max:255',
                'last_name'  => 'required|string|max:255',
                'email'      => 'required|string|email|max:255|unique:users|confirmed|'
                    . 'not_regex:/(.+)@boosterthon\.com$/i',
                'password'   => 'required|string|min:7|max:20',
                'phone'      => 'required|digits:10',
                'year'       => 'required|integer',
                'day'        => 'required|integer',
                'month'      => 'required|integer',
            ],
            [
                'required'        => ':attribute is required.',
                'digits'          => Lang::get('validation.phone'),
                'email.not_regex' => Lang::get('validation.boosterthon_email'),
                'email.confirmed' => Lang::get('validation.email_confirmation'),
            ],
            [
                'first_name'         => Lang::get('register.first_name'),
                'last_name'          => Lang::get('register.last_name'),
                'email'              => Lang::get('register.email'),
                'password'           => Lang::get('register.password'),
                'phone'              => Lang::get('register.phone'),
                'month'              => Lang::get('register.month'),
                'day'                => Lang::get('register.day'),
                'year'               => Lang::get('register.year'),
            ]
        );

        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Entities\User
     */
    protected function create(array $data)
    {
        DB::beginTransaction();
        $registerModel = new RegisterModel();
        $parentUser    = $registerModel->registerParent($data);
        DB::commit();
        return $parentUser;
    }

    public function validateTeacherRegistrationCode($teacherRegistrationCode)
    {
        //Remove hyphen to allow teachers the option to submit with or without hyphen
        $teacherRegistrationCode = str_replace('-', '', $teacherRegistrationCode);
        $registerModel           = new RegisterModel();
        $result                  = $registerModel->validateTeacherRegistrationCode($teacherRegistrationCode);
        if ($result['success'] === true) {
            $teacherUser = $registerModel->registerTeacher(Auth::user(), $teacherRegistrationCode);
            if ($teacherUser) {
                $teacherUser->parents()->save(Auth::user());
                return response()->json(['success'=> true, 'user'=> $teacherUser]);
            } else {
                return response()->json(false);
            }
        }
        return response()->json($result);
    }

    /**
     * Validates if an email address is available to register
     *
     * @param String email address
     * @return Boolean available
     */
    public function validateEmailAddress(ValidateEmailAddressRequest $request)
    {
        if (User::where('email', $request->emailAddress)->exists()) {
            return response()->json(['email_available'=> false], 200);
        }
        return response()->json(['email_available'=> true], 200);
    }

    public function validateProfileComplete()
    {
        $user = Auth::user();

        $hasIncompleteProfile = empty($user->first_name) ||
            empty($user->last_name) ||
            empty($user->email) ||
            empty($user->phone) ||
            empty($user->dob);

        if ($hasIncompleteProfile) {
            return response()->json(['valid'=> false], 200);
        }

        return response()->json(['valid'=> true], 200);
    }
}
