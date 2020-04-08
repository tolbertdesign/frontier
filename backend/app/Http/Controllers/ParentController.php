<?php

namespace App\Http\Controllers;

use App\Entities\User;
use App\Http\Requests\UpdateParentRequest;
use Illuminate\Support\Facades\Auth;

class ParentController extends Controller
{
    public function update(UpdateParentRequest $request)
    {
        Auth::user()->update($request->validated());
        return Auth::user();
    }
}
