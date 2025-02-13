<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return view('tasks.index', ['tasks' => Task::all()]);
    }

    public function store(Request $request)
    {
        $task = Task::create($request->validate(['name' => 'required']));
        return response()->json($task);
    }

    public function update(Task $task)
    {
        $task->update(['completed' => !$task->completed]);
        return response()->json(['completed' => $task->completed]);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['success' => true]);
    }
}
