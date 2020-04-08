<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function addTask(Request $request)
    {
        $task = Task::create([
            'task' => $request->task
        ]);
        return response()->json(['message' => 'task added!'], 200);
    }

    public function getTask()
    {
        return response()->json(['tasks' => Task::all()], 200);
    }
}
