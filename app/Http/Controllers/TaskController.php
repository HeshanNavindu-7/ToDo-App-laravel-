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
        // Validate input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        // Create new task
        $task = Task::create($validatedData);

        return response()->json($task, 201);
    }

    public function update(Request $request, Task $task)
    {
        // Toggle task completion status
        $task->update(['completed' => !$task->completed]);

        return response()->json(['id' => $task->id, 'completed' => $task->completed]);
    }

    public function destroy(Task $task)
    {
        // Delete task
        $task->delete();

        return response()->json(['success' => true, 'id' => $task->id]);
    }
}
