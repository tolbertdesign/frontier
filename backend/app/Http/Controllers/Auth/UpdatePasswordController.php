<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Response\Code as Http_Code;
use App\Entities\User;
use App\Http\Response\Json as Response;
use App\Http\Requests\PasswordChangeRequest;

class UpdatePasswordController extends Controller
{

    /**
     * Change logged in user's password.
     *
     * @param  \Illuminate\Http\PasswordChangeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function change(PasswordChangeRequest $request)
    {
        $user = User::find(Auth::id());

        // Verify old password
        if (!Hash::check($request->current, $user->password)) {
            return Response::asError(Http_Code::FAILED_VALIDATION, ['current'=> ['Current password does not match']]);
        }

        // Verify confirm password matches
        if ($request->password !== $request->password_confirmation) {
            return Response::asError(Http_Code::FAILED_VALIDATION, ['password_match_error'=> ['Passwords do not match']]);
        }


        // Make new password
        $user->password = Hash::make($request->password);
        $user->save();

        return Response::asSuccess();
    }
}
