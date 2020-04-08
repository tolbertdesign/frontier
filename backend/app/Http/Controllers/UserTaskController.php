<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserTaskRequest;
use Auth;
use App\Entities\UserTask;
use App\Http\Response\Json;

class UserTaskController extends Controller
{

    public function update(UpdateUserTaskRequest $request, UserTask $userTask)
    {
        if ($request->completed_on_date) {
            $userTask->setAsComplete();
        } else {
            $userTask->setAsIncomplete();
        }

        $userTask->save();

        return Json::asSuccess(['userTask' => $userTask]);
    }
}
